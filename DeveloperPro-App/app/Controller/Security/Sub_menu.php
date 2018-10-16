<?php
/**
 * Created by Nelson Andres Guerrero (PixelProgramer).
 * User: dp-s4-pc
 * Date: 10/16/2018
 * Time: 7:41 AM
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->group('/api-security/', function () {
    $this->group('sub_menu/', function () {
        $this->post('newSubMenu', function (Request $request) {
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
                        $se_sub_menu_priority = (isset($parametrosJson->se_sub_menu_priority)) ? $parametrosJson->se_sub_menu_priority : null;
                        $se_menu_id_fk_sub_menu = (isset($parametrosJson->se_menu_id_fk_sub_menu)) ? $parametrosJson->se_menu_id_fk_sub_menu : null;
                        $se_sub_menu_state = (isset($parametrosJson->se_sub_menu_state)) ? $parametrosJson->se_sub_menu_state : null;
                        $se_sub_menu_active = (isset($parametrosJson->se_sub_menu_active)) ? $parametrosJson->se_sub_menu_active : null;
                        $se_header_id_fk_seub_menu = (isset($parametrosJson->se_header_id_fk_seub_menu)) ? $parametrosJson->se_header_id_fk_seub_menu : null;
                        $sql = "select se_sm.* from security.se_sub_menus se_sm where se_sm.se_header_id_fk_seub_menu = '$se_header_id_fk_seub_menu'";
                        $r = $connection->complexQuery($sql);
                        $se_sub_menu_priority = pg_num_rows($r) + 1;
                        $sql = "INSERT INTO security.se_sub_menus(
                                se_sub_menu_priority, se_menu_id_fk_sub_menu,
                                 se_sub_menu_state, se_sub_menu_active, se_header_id_fk_seub_menu)
                                VALUES ( '$se_sub_menu_priority', '$se_menu_id_fk_sub_menu', '$se_sub_menu_state', '$se_sub_menu_active', '$se_header_id_fk_seub_menu');";
                        $r = $connection->simpleQuery($sql);
                        $data = [
                            'code' => '1001',
                            'msg' => 'Menu agregado de forma correcta'
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

        $this->post('deletedSubeMenu', function (Request $request) {
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
                        $se_sub_menu_id = (isset($parametrosJson->se_sub_menu_id)) ? $parametrosJson->se_sub_menu_id : null;
                        $sql = "DELETE FROM security.se_sub_menus
                                WHERE se_sub_menu_id = '$se_sub_menu_id';";
                        $r = $connection->simpleQuery($sql);
                        $data = [
                            'code' => '1001',
                            'msg' => 'Menu eliminado de forma correcta'
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