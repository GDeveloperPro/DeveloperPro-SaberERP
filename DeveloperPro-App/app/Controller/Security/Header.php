<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->group('/api-security/', function () {
    $this->group('header/', function () {
        $this->post('updatedHeaderPriority', function (Request $request) {
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
                        $json = (isset($parametrosJson->menu)) ? $parametrosJson->menu : null;
                        $menuArray = json_decode($json, true);
                        for ($i = 0; $i < count($menuArray); $i++) {
                            $id_header = $menuArray[$i]['id_cabezera'];
                            $header_priority = $menuArray[$i]['prioridad_cabezera'];
                            $sql = "UPDATE security.se_headers
                                SET se_header_priority='$header_priority', 
                                WHERE se_header_id='$id_header';";
                            $connection->simpleQuery($sql);
                            for ($j = 0; $j < count($menuArray[$i]['subMenu']); $j++) {
                                $id_sub_menu = $menuCompleto[$i]['subMenus'][$j]['se_sub_menu_id'];
                                $sub_menu_priority = $menuCompleto[$i]['subMenus'][$j]['se_sub_menu_priority'];
                                $sql = "UPDATE security.se_sub_menus
                                    SET  se_sub_menu_priority='$sub_menu_priority'
                                    WHERE se_sub_menu_id='$id_sub_menu';";
                                $connection->simpleQuery($sql);
                            }
                        }
                        $data = [
                            'code' => '1001',
                            'msg' => 'Menu cargado',
                            'data' => $permisos
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
        $this->post('newHeader', function (Request $request) {
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
                        $se_header_description = (isset($parametrosJson->se_header_description)) ? $parametrosJson->se_header_description : null;
                        $se_header_state = (isset($parametrosJson->se_header_state)) ? $parametrosJson->se_header_state : null;
                        $se_rol_id_fk_header = (isset($parametrosJson->se_rol_id_fk_header)) ? $parametrosJson->se_rol_id_fk_header : null;
                        $se_header_priority = (isset($parametrosJson->se_header_priority)) ? $parametrosJson->se_header_priority : null;
                        $se_header_active = (isset($parametrosJson->se_header_active)) ? $parametrosJson->se_header_active : null;
                        $sql = "select se_header.* from security.se_headers se_header where se_header.se_rol_id_fk_header = '$se_rol_id_fk_header' ";
                        $r = $connection->complexQuery($sql);
                        $se_header_priority = pg_num_rows($r) + 1;
                        $sql = "INSERT INTO security.se_headers(
                                se_header_description, se_header_state, se_rol_id_fk_header, 
                                se_header_priority, se_header_created_at, se_header_updated_at, se_header_active)
                                VALUES ('$se_header_description', '$se_header_state', '$se_rol_id_fk_header', '$se_header_priority', 
                                '$fecha_ingreso', '$fecha_ingreso', '$se_header_active');";

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
    });
});