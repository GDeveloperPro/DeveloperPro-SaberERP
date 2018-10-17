<?php
/**
 * Created by DeveloperPro ®.
 * User: Gilberto Guerrero Quinayas
 * Date: 25/09/2018
 * Time: 5:36 PM
 */


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Service\Helpers;
use Service\Connections;
use Service\EmailTemplate;

$app->group('/api-security/', function () {
    $this->group('users/', function () {
        $this->post('checkToken', function (Request $request, Response $response, array $args) {
            $helper = new Helpers();
            $connection = new Connections();

            $authorization = $request->getParsedBody();
            $authorization = $authorization['authorization'];

            return json_encode($helper->jwrAuth->checkToken($authorization));
        });
        $this->post('logInFacebook', function (Request $request, Response $response, array $args) {
            $helper = new Helpers();
            $connection = new Connections();

            $json = $request->getParsedBody();
            $json = $json['json'];
            $json = json_decode($json);

            return $helper->jwrAuth->signInFacebook();
        });
        $this->post('logIn', function (Request $request, Response $response, array $args) {
            $parametros = $request->getParsedBody();
            $json = $parametros['json'];
            $helper = new Helpers();
            if ($json != null) {
                $parametros = json_decode($json);
                $correo = (isset($parametros->se_user_email)) ? $parametros->se_user_email : null;
                $contrasena = (isset($parametros->se_user_password)) ? $parametros->se_user_password : null;
                $getHash = (isset($parametros->has)) ? $parametros->has : false;
                $conexion = new Connections();
                $pwd = hash('SHA256', $contrasena);
                $sql = "select * from security.se_users se_user inner join security.se_profiles se_profile on 
                            se_user.se_user_id=se_profile.se_user_id_fk_profiles 
                            where se_user.se_user_email ='$correo' and se_user.se_user_password='$pwd' and se_user.se_user_active = '1'";
                $r = $conexion->complexQueryNonAssociative($sql);
                if ($r > 0) {
                    $usuario = $r;
                    if ($usuario['se_user_active'] != '0') {
                        if ($correo == $usuario['se_user_email'] && $pwd == $usuario['se_user_password']) {
                            $jwtAuth = new \Service\JwtAuth();
                            $jwt = $jwtAuth->signIn($usuario, $getHash);
                            $data = [
                                'code' => 1001,
                                'msg' => 'Bienvenido',
                                'data' => $jwt
                            ];
                        } else {
                            $data = [
                                'code' => '1007',
                                'msg' => 'Lo sentimos, correo o contraseña incorrectos'
                            ];
                        }
                    } else {
                        $data = [
                            'code' => '1007',
                            'msg' => 'Lo sentimos, su cuenta esta inactiva'
                        ];
                    }
                } else {
                    $data = [
                        'code' => '1007',
                        'msg' => 'Lo sentimos, no se encontro una cuenta con ese correo'
                    ];
                }
            } else {
                $data = [
                    'code' => '1007',
                    'msg' => 'Lo sentimos, no se encontro una cuenta con ese correo'
                ];
            }
            echo $helper->checkCode($data);
        });
        $this->post('new', function (Request $request, Response $response, array $args) {
            $helper = new Helpers();
            $connection = new Connections();
            $emailTemplate = new EmailTemplate();

            $json = $request->getParsedBody();
            $json = $json['json'];
            $json = json_decode($json);

            $name = (isset($json->name)) ? $json->name : null;
            $surname = (isset($json->surname)) ? $json->surname : null;
            $profile_state = 1;

            $email = (isset($json->email)) ? $json->email : null;
            $password = (isset($json->password)) ? $json->password : null;
            $code = $helper->codeGenerate(100000, 999999);
            $created_at = date('Y-m-d H:i:s');
            $state_type = 'PENDIENTE';
            $state = 0;

            if ($password != null) {
                $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
                if ($helper->isValidEmail($email)) {
                    $sqlQueryUser = "SELECT se_user_id, se_user_email, se_user_password, se_user_code, se_user_last_connection, se_user_created_at, se_user_state_type, se_user_state, se_user_google_id, se_user_twitter_id, se_user_facebook_id, se_role_id_fk, se_group_id_fk
                                    FROM security.se_users WHERE se_user_email = '$email';";
                    $resultQueryUser = $connection->complexQueryNonAssociative($sqlQueryUser);
                    $resultUserId = $helper->jsonEncodeDecode($sqlQueryUser);

                    if (isset($resultQueryUser) && $resultQueryUser == 0) {
                        if ($name != null) {
                            $sqlInsertProfile = "INSERT INTO security.se_profiles(se_profile_name, se_profile_surname, se_profile_state, se_user_id_fk)
                                            VALUES ('$name', '$surname', '$profile_state' , $resultUserId->id) RETURNING se_profile_id;";
                            $resultInsertProfile = $connection->simpleQueryId($sqlInsertProfile);

                            if (isset($resultInsertProfile) && $resultInsertProfile != 0) {
                                $sqlInsertUser = "INSERT INTO security.se_users(
                                            se_user_email, se_user_password, se_user_code, se_user_created_at, se_user_state_type, se_user_state, se_user_profile_id)
                                            VALUES ('$email', '$password', '" . base64_encode($code) . "', '$created_at', '$state_type', '$state', $resultInsertProfile) RETURNING se_user_id;";
                                $resultInsertUser = $connection->simpleQueryId($sqlInsertUser);

                                if (isset($resultInsertUser) && $resultInsertUser != 0) {
                                    $helper->sendEmail('no-reply', getenv('EMAIL_EMAIL'), getenv('EMAIL_PASS'), getenv('EMAIL_SMTP'), getenv('EMAIL_PORT'), getenv('EMAIL_AUTH'), $surname . ' ' . $name, $email, 'prueba email', $emailTemplate->UserCodeEmail('CODE', '', $code), null, null);

                                    $data = array(
                                        'code' => '1001',
                                        'msg' => 'Success'
                                    );
                                } else {
                                    $data = array(
                                        'code' => '1005',
                                        'msg' => 'Error in user creation'
                                    );
                                }
                            } else {
                                $data = array(
                                    'code' => '1005',
                                    'msg' => 'Error in profile creation'
                                );
                            }
                        } else {
                            $data = array(
                                'code' => '1005',
                                'msg' => 'Invalid name'
                            );
                        }
                    } else {
                        $data = array(
                            'code' => '1005',
                            'msg' => 'User exist'
                        );
                    }
                } else {
                    $data = array(
                        'code' => '1005',
                        'msg' => 'Invalid email'
                    );
                }
            } else {
                $data = array(
                    'code' => '1005',
                    'msg' => 'Invalid password'
                );
            }

            $data = $helper->jsonEncodeDecode($data);

            return $helper->checkCode($data);
        });
        $this->post('validate', function (Request $request, Response $response, array $args) {
            $helper = new Helpers();
            $connection = new Connections();

            $json = $request->getParsedBody();
            $json = $json['json'];
            $json = json_decode($json);

            $email = (isset($json->email)) ? $json->email : null;
            $code = (isset($json->code)) ? $json->code : null;

            $sqlQueryUser = "SELECT se_user_id, se_user_email, se_user_password, se_user_code, se_user_last_connection, se_user_created_at, se_user_state_type,
                                                se_user_state, se_user_role_id, se_user_profile_id, se_user_group_id, se_user_fb_id, se_user_google_id
                                    FROM security.se_users WHERE se_user_email = '$email' AND se_user_code = '" . base64_encode($code) . "';";
            $resultQueryUser = $connection->complexQueryNonAssociative($sqlQueryUser);

            if (isset($resultQueryUser) && $resultQueryUser != 0) {
                $resultQueryUser = $helper->jsonEncodeDecode($resultQueryUser);
                if ($resultQueryUser->se_user_state_type == 'PENDIENTE' && $resultQueryUser->se_user_state) {
                    $sqlUpdateUser = "UPDATE security.se_users
                                            SET se_user_state_type='ACTIVO', se_user_state='true'
                                            WHERE se_user_id = $resultQueryUser->se_user_id;";
                    $resultUpdateUser = $connection->simpleQuery($sqlUpdateUser);

                    $data = array(
                        'code' => '1001',
                        'msg' => 'Success'
                    );
                } else {
                    $data = array(
                        'code' => '1002',
                        'msg' => 'User is active'
                    );
                }
            } else {
                $data = array(
                    'code' => '1005',
                    'msg' => 'Data incorrect'
                );
            }

            $data = $helper->jsonEncodeDecode($data);

            return $helper->checkCode($data);
        });
        $this->post('listUser', function (Request $request) {
            $parametros = $request->getParsedBody();
            $token = (isset($parametros['token'])) ? $parametros['token'] : null;
            if ($token != null) {
                $jwt = new \Service\JwtAuth();
                $helper = new \Service\Helpers();
                $validacionToken = $jwt->checkToken($token);
                if ($validacionToken == true) {
                    $connection = new \Service\Connections();
                    $sql = "select * from security.se_users se_user inner join security.se_profiles se_profile on 
                            se_user.se_user_id=se_profile.se_user_id_fk_profiles 
                            where se_user.se_user_active = '1'";
                    $r = $connection->complexQueryAssociative($sql);
                    $data = [
                        'code' => '1001',
                        'msg' => 'Usuarios cargados cargados',
                        'data' => $r
                    ];
                } else {
                    $data = [
                        'code' => '1008'
                    ];
                }
            } else {
                $data = [
                    'code' => '1008'
                ];
            }

            echo $helper->checkCode($data);
        });
        $this->post('newUser', function (Request $request) {
            $parametros = $request->getParsedBody();
            $jsonUser = (isset($parametros['jsonUser'])) ? $parametros['jsonUser'] : null;
            $jsonProfile = (isset($parametros['jsonProfile'])) ? $parametros['jsonProfile'] : null;
            if ($jsonUser != null && $jsonProfile != null) {
                $token = (isset($parametros['token'])) ? $parametros['token'] : null;
                if ($token != null) {
                    $jwt = new \Service\JwtAuth();
                    $helper = new \Service\Helpers();
                    $validacionToken = $jwt->checkToken($token);
                    if ($validacionToken == true) {
                        $fecha_ingreso = date('Y-m-d H:i');
                        $connection = new \Service\Connections();
                        $parametrosJsonUser = json_decode($jsonUser);
                        $parametrosJsonProfile = json_decode($jsonProfile);
                        $se_user_email = strtolower((isset($parametrosJsonUser->se_user_email)) ? $parametrosJsonUser->se_user_email : null);
                        $se_user_password = (isset($parametrosJsonUser->se_user_password)) ? $parametrosJsonUser->se_user_password : null;
                        $se_user_state = strtolower((isset($parametrosJsonUser->se_user_state)) ? $parametrosJsonUser->se_user_state : null);

                        $se_profile_identification = (isset($parametrosJsonProfile->se_profile_identification)) ? $parametrosJsonProfile->se_profile_identification : null;
                        $se_profile_name = strtolower((isset($parametrosJsonProfile->se_profile_name)) ? $parametrosJsonProfile->se_profile_name : null);
                        $se_profile_surname = strtolower((isset($parametrosJsonProfile->se_profile_surname)) ? $parametrosJsonProfile->se_profile_surname : null);
                        $se_profile_phone = (isset($parametrosJsonProfile->se_profile_phone)) ? $parametrosJsonProfile->se_profile_phone : null;
                        $se_profile_state = (isset($parametrosJsonProfile->se_profile_state)) ? $parametrosJsonProfile->se_profile_state : null;
                        if ($helper->isValidEmail($se_user_email)) {
                            $se_user_email = strtolower($se_user_email);
                            $sql = "select * from security.se_users se_use where se_use.se_user_email like '$se_user_email'";
                            $r = $connection->complexQuery($sql);
                            if (pg_num_rows($r) == 0) {
                                $sql = "select * from security.se_profiles se_prof where se_prof.se_profile_identification like '$se_profile_identification'";
                                $r = $connection->complexQuery($sql);
                                if (pg_num_rows($r) == 0) {
                                    $activatedCode = time() . rand(0, 1000);
                                    $password = time();
                                    $passwordHas = hash('SHA256', $password);

                                    //Envio de correo de activacion
                                    $sql = "INSERT INTO security.se_users(
                                        se_user_email, se_user_password, se_user_code, 
                                        se_user_created_at, se_user_state, se_role_id_fk_users, se_group_id_fk_users, se_user_active)
                                        VALUES ('$se_user_email', '$passwordHas', '$activatedCode',  '$fecha_ingreso', 'INACTIVO',  ?, ?, ?);";


                                } else {
                                    $data = [
                                        'code' => '1007',
                                        'msg' => 'Lo sentimos este documento de identidad ya se encuentra registrado'
                                    ];
                                }
                            } else {
                                $data = [
                                    'code' => '1007',
                                    'msg' => 'Lo sentimos este correo ya se encuentra registrado'
                                ];
                            }
                        } else {
                            $data = [
                                'code' => '1007',
                                'msg' => 'Lo sentimos este correo no existe'
                            ];
                        }
                        $r = $connection->simpleQuery($sql);
                        $data = [
                            'code' => '1001',
                            'msg' => 'Rol creado de forma correcta'
                        ];
                    } else {
                        $data = [
                            'code' => '1008'
                        ];
                    }
                } else {
                    $data = [
                        'code' => '1008'
                    ];
                }
            } else {
                $data = [
                    'code' => '1007',
                    'msg' => 'JSON, no valido.'
                ];
            }
            echo $helper->checkCode($data);
        });
    });
});