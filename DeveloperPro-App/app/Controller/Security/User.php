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
                $helper = new Helpers();
                $connection = new Connections();
                
                $json = $request->getParsedBody();
                $json = $json['json'];
                $json = json_decode($json);
                
                $email = (isset($json->email)) ? $json->email : null;
                $password = (isset($json->password)) ? $json->password : null;
                $gethash = (isset($json->gethash)) ? $json->gethash : null;
                
                if ($email != null && $password != null)
                    $signUp = $helper->jwrAuth->signIn($email, $password, $gethash);
                
                return json_encode($signUp);
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
        });
    });