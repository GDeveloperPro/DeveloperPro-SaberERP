<?php
    /**
     * Created by DeveloperPro ®.
     * User: Gilberto Guerrero Quinayas
     * Date: 21/09/2018
     * Time: 3:20 PM
     */
    
    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;
    
    $app->group('/api-security/', function () {
        $this->group('roles/', function () {
            $this->post('listRol', function (Request $request) {
                $parametros = $request->getParsedBody();
                $token = (isset($parametros['token'])) ? $parametros['token'] : null;
                if ($token != null) {
                    $jwt = new \Service\JwtAuth();
                    $helper = new \Service\Helpers();
                    $validacionToken = $jwt->checkToken($token);
                    if ($validacionToken == true) {
                        $connection = new \Service\Connections();
                        $sql = "select * from security.se_rols se_rol where se_rol.se_rol_active = '1'";
                        $r = $connection->complexQueryAssociative($sql);
                        $data = [
                            'code' => '1001',
                            'msg' => 'Menus cargados',
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

            $this->post('newRol', function (Request $request) {
                $parametros = $request->getParsedBody();
                $json = (isset($parametros['json'])) ? $parametros['json'] : null;
                if ($json != null) {
                    $token = (isset($parametros['token'])) ? $parametros['token'] : null;
                    if ($token != null) {
                        $jwt = new \Service\JwtAuth();
                        $helper = new \Service\Helpers();
                        $validacionToken = $jwt->checkToken($token);
                        if ($validacionToken == true) {
                            $fecha_ingreso = date('Y-m-d H:i');
                            $connection = new \Service\Connections();
                            $parametrosJson = json_decode($json);
                            $se_rol_description = (isset($parametrosJson->se_rol_description)) ? $parametrosJson->se_rol_description : null;
                            $se_rol_state = (isset($parametrosJson->se_rol_state)) ? $parametrosJson->se_rol_state : null;
                            $se_rol_active = (isset($parametrosJson->se_rol_active)) ? $parametrosJson->se_rol_active : null;

                            $sql = "INSERT INTO security.se_rols(
                                se_rol_description, se_rol_state, 
                                se_rol_created_at, se_rol_updated_at, se_rol_active)
                                VALUES ('$se_rol_description', '$se_rol_state', '$fecha_ingreso', '$fecha_ingreso', '$se_rol_active');";

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
            $this->post('updatedRol', function (Request $request) {
                $parametros = $request->getParsedBody();
                $json = (isset($parametros['json'])) ? $parametros['json'] : null;
                if ($json != null) {
                    $token = (isset($parametros['token'])) ? $parametros['token'] : null;
                    if ($token != null) {
                        $jwt = new \Service\JwtAuth();
                        $helper = new \Service\Helpers();
                        $validacionToken = $jwt->checkToken($token);
                        if ($validacionToken == true) {
                            $fecha_ingreso = date('Y-m-d H:i');
                            $connection = new \Service\Connections();
                            $parametrosJson = json_decode($json);
                            $se_rol_id = (isset($parametrosJson->se_rol_id)) ? $parametrosJson->se_rol_id : null;
                            $se_rol_description = (isset($parametrosJson->se_rol_description)) ? $parametrosJson->se_rol_description : null;
                            $se_rol_state = (isset($parametrosJson->se_rol_state)) ? $parametrosJson->se_rol_state : null;
                            $se_rol_active = (isset($parametrosJson->se_rol_active)) ? $parametrosJson->se_rol_active : null;

                            $sql = "UPDATE security.se_rols
                                    SET  se_rol_description='$se_rol_description', se_rol_state='$se_rol_state', 
                                    se_rol_updated_at='$fecha_ingreso', se_rol_active='$se_rol_active'
                                    WHERE se_rol_id='$se_rol_id';";

                            $r = $connection->simpleQuery($sql);
                            $data = [
                                'code' => '1001',
                                'msg' => 'Rol actualizado de forma correcta'
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