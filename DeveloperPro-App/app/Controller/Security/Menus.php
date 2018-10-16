<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->group('/api-security/', function () {
    $this->group('menu/', function () {
        $this->post('listMenu', function (Request $request) {
            $parametros = $request->getParsedBody();
            $token = (isset($parametros['token'])) ? $parametros['token'] : null;
            if ($token != null) {
                $jwt = new \Service\JwtAuth();
                $helper = new \Service\Helpers();
                $validacionToken = $jwt->checkToken($token);
                if ($validacionToken == true) {
                    $connection = new \Service\Connections();
                    $sql = "select * from security.se_menus se_menu where se_menu.se_menu_active = '1'";
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

        $this->post('newMenu', function (Request $request) {
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
                        $se_menu_description = (isset($parametrosJson->se_menu_description)) ? $parametrosJson->se_menu_description : null;
                        $se_menu_component_name = (isset($parametrosJson->se_menu_component_name)) ? $parametrosJson->se_menu_component_name : null;
                        $se_menu_rute = (isset($parametrosJson->se_menu_rute)) ? $parametrosJson->se_menu_rute : null;
                        $se_menu_state = (isset($parametrosJson->se_menu_state)) ? $parametrosJson->se_menu_state : null;
                        $se_menu_icon = (isset($parametrosJson->se_menu_icon)) ? $parametrosJson->se_menu_icon : null;
                        $se_menu_default_page = (isset($parametrosJson->se_menu_default_page)) ? $parametrosJson->se_menu_default_page : null;
                        $sql = "INSERT INTO security.se_menus(
                                 se_menu_description, se_menu_component_name, se_menu_rute, se_menu_state, 
                                se_menu_icon, se_menu_default_page, se_menu_active, se_menu_created_at)
                                VALUES ( '$se_menu_description', '$se_menu_component_name', '$se_menu_rute', '$se_menu_state', 
                                '$se_menu_icon', '$se_menu_default_page','1','$fecha_ingreso');";

                        $r = $connection->simpleQuery($sql);
                        $data = [
                            'code' => '1001',
                            'msg' => 'Menu creado de forma correcta'
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
        $this->post('updatedMenu', function (Request $request) {
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
                        $se_menu_id = (isset($parametrosJson->se_menu_id)) ? $parametrosJson->se_menu_id : null;
                        $se_menu_description = (isset($parametrosJson->se_menu_description)) ? $parametrosJson->se_menu_description : null;
                        $se_menu_component_name = (isset($parametrosJson->se_menu_component_name)) ? $parametrosJson->se_menu_component_name : null;
                        $se_menu_rute = (isset($parametrosJson->se_menu_rute)) ? $parametrosJson->se_menu_rute : null;
                        $se_menu_state = (isset($parametrosJson->se_menu_state)) ? $parametrosJson->se_menu_state : null;
                        $se_menu_icon = (isset($parametrosJson->se_menu_icon)) ? $parametrosJson->se_menu_icon : null;
                        $se_menu_default_page = (isset($parametrosJson->se_menu_default_page)) ? $parametrosJson->se_menu_default_page : null;
                        $se_menu_active = (isset($parametrosJson->se_menu_active)) ? $parametrosJson->se_menu_active : null;
                        $sql = "UPDATE security.se_menus
                                SET se_menu_description='$se_menu_description', se_menu_component_name='$se_menu_component_name', se_menu_rute='$se_menu_rute', se_menu_state='$se_menu_state', 
                                se_menu_icon='$se_menu_icon', se_menu_default_page='$se_menu_default_page', se_menu_active='$se_menu_active'
                                WHERE se_menu_id='$se_menu_id';";
                        $r = $connection->simpleQuery($sql);
                        $data = [
                            'code' => '1001',
                            'msg' => 'Menu actualizado de forma correcta'
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


        $this->post('listMenuComplet', function (Request $request) {
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
                        $sql = "select se_header.*, se_ro.se_rol_description from security.se_rols se_ro 
                                join security.se_headers se_header on se_ro.se_rol_id=se_header.se_rol_id_fk_header 
                                where se_ro.se_rol_id='$se_rol_id' order by se_header.se_header_priority asc";

                        $r = $connection->complexQueryAssociative($sql);
                        if ($r != 0) {
                            $permisos = array();
                            for ($i = 0; $i < count($r); $i++) {
                                $id_header = $r[$i]['se_header_id'];
                                $header_priority = $r[$i]['se_header_priority'];
                                $sql = "select se_menu.*,se_rol.se_rol_description,se_sm.se_sub_menu_priority,se_sm.se_sub_menu_id from security.se_rols se_rol 
                                        join security.se_headers se_header on se_rol.se_rol_id=se_header.se_rol_id_fk_header
                                        join security.se_sub_menus se_sm on se_header.se_header_id=se_sm.se_header_id_fk_seub_menu
                                        join security.se_menus se_menu on se_menu.se_menu_id=se_sm.se_menu_id_fk_sub_menu
                                        where se_header.se_header_id = '$id_header' order by se_sm.se_sub_menu_priority asc";
                                $r2=$connection->complexQueryAssociative($sql);
                                array_push($permisos, [
                                    'id_cabezera' => $id_header,
                                    'descripcion_cabezera' => $r[$i]['se_header_description'],
                                    'estado_cabezera' => $r[$i]['se_header_state'],
                                    'prioridad_cabezera' => $header_priority,
                                    'subMenus' => $r2
                                ]);
                            }
                        }
                        $data = [
                            'code' => '1001',
                            'msg' => 'Menu cargado',
                            'data'=>$permisos
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