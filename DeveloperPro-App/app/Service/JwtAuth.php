<?php
    /**
     * Created by DeveloperPro ®.
     * User: Gilberto Guerrero Quinayas
     * Date: 25/09/2018
     * Time: 5:35 PM
     */
    
    namespace Service;


    use Firebase\JWT\JWT;
    use Facebook\Facebook;

    /**
     * Class JwtAuth
     *
     * @package Service
     */
    class JwtAuth
    {
        /**
         * @var string
         */
        private $key;
    
        /**
         * JwtAuth constructor.
         */
        public function __construct()
        {
            $this->key = base64_encode(getenv('SECRET_KEY'));
        }
    
        /**
         * @param      $email
         * @param      $password
         * @param bool $getHash
         *
         * @return object|string
         */
        public function signIn($usuario, $getHash = false)
        {

            $conexion = new Connections();
            $fecha_ingreso = date('Y-m-d H:i');
            $sql = "update security.se_users set se_user_last_connection = '$fecha_ingreso' where se_user_email= '$usuario[se_user_email]'";
            $conexion->complexQueryNonAssociative($sql);
            $sql ="select * from security.se_users se_use 
                    join security.se_rols se_rol on se_use.se_role_id_fk_users = se_rol.se_rol_id
                    join security.se_headers se_header on se_header.se_rol_id_fk_header=se_rol.se_rol_id
                    where se_use.se_user_email like '$usuario[se_user_email]' order by se_header.se_header_priority asc;";
            $r = $conexion->complexQueryAssociative($sql);
            $permisos = array();
            $rolDescripcion ='';
            for ($i = 0; $i<count($r); $i++)
            {
                $id_cabezera=$r[$i]['se_header_id'];
                $sql = "select se_header.*, se_menu.*,se_sm.* from security.se_users se_use 
                        join security.se_rols se_rol on se_use.se_role_id_fk_users = se_rol.se_rol_id
                        join security.se_headers se_header on se_header.se_rol_id_fk_header=se_rol.se_rol_id
                        join security.se_sub_menus se_sm on se_header.se_header_id = se_sm.se_header_id_fk_seub_menu
                        join security.se_menus se_menu on se_menu.se_menu_id=se_sm.se_menu_id_fk_sub_menu
                        where se_header.se_header_id='$id_cabezera' and  se_use.se_user_email like '$usuario[se_user_email]' order by se_sm.se_sub_menu_priority asc;";
                $rolDescripcion = $r[$i]['se_rol_description'];
                $r2 = $conexion->complexQueryAssociative($sql);
                array_push($permisos,[
                    'id_cabezera'=>$id_cabezera,
                    'descripcion_cabezera'=>$r[$i]['se_header_description'],
                    'estado_cabezera'=>$r[$i]['se_header_state'],
                    'subMenus'=>$r2
                ]);
            }
            $sql="select se_menu.* from security.se_users se_use 
                        join security.se_rols se_rol on se_use.se_role_id_fk_users = se_rol.se_rol_id
                        join security.se_headers se_header on se_header.se_rol_id_fk_header=se_rol.se_rol_id
                        join security.se_sub_menus se_sm on se_header.se_header_id = se_sm.se_header_id_fk_seub_menu
                        join security.se_menus se_menu on se_menu.se_menu_id=se_sm.se_menu_id_fk_sub_menu
                        where se_use.se_user_email like '$usuario[se_user_email]';";
            $r = $conexion->complexQueryAssociative($sql);
            $token = array(
                'sub' => $usuario['se_user_id'],
                'documento' => $usuario['se_profile_identification'],
                'nombre' => $usuario['se_profile_name'],
                'apellido' => $usuario['se_profile_surname'],
                'correo' => $usuario['se_user_email'],
                'telefono' => $usuario['se_profile_phone'],
                'direccion' => $usuario['se_profile_address'],
                'rol' => $usuario['se_role_id_fk_users'],
                'permisos'=>$r,
                'menu'=>$permisos,
                'fecha_creacion' => $usuario['se_user_created_at'],
                'ultimo_ingreso'=>$fecha_ingreso,
                'rol_descripcion' => $rolDescripcion,
                'iat' => time(),
                'exp' => time() + (7 * 24 * 60 * 60)
            );
            $jwt = JWT::encode($token, $this->key, 'HS512');
            $decoded = JWT::decode($jwt, $this->key, array('HS512'));

            if ($getHash)
                return $decoded;
            else
                return $jwt;
        }
    
        /**
         * @param      $jwt
         * @param bool $getIdentity
         *
         * @return bool|object
         */
        public function checkToken($jwt, $getIdentity = false)
        {
            $auth = false;
        
            try {
                $decoded = JWT::decode($jwt, $this->key, array('HS512'));
            } catch (\UnexpectedValueException $e) {
                $auth = false;
            } catch (\DomainException $e) {
                $auth = false;
            }
        
            if (isset($decoded->sub)) {
                $auth = true;
            } else {
                $auth = false;
            }
        
            if ($getIdentity == true) {
                return $decoded;
            } else {
                return $auth;
            }
        }
    
        /**
         * @throws \Facebook\Exceptions\FacebookSDKException
         */
        public function signInFacebook()
        {
            $fb = new Facebook([
                'app_id' => getenv('APP_FB_ID'),
                'app_secret' => getenv('APP_FB_SECRET'),
                'default_graph_version' => 'v3.1',
                //'default_access_token' => '{access-token}', // optional
            ]);
        
            // Use one of the helper classes to get a Facebook\Authentication\AccessToken entity.
            //   $helper = $fb->getRedirectLoginHelper();
            //   $helper = $fb->getJavaScriptHelper();
            //   $helper = $fb->getCanvasHelper();
            //   $helper = $fb->getPageTabHelper();
        
            try {
                // Get the \Facebook\GraphNodes\GraphUser object for the current user.
                // If you provided a 'default_access_token', the '{access-token}' is optional.
                $response = $fb->get('/me', '{access-token}');
            } catch (\Facebook\Exceptions\FacebookResponseException $e) {
                // When Graph returns an error
                echo 'Graph returned an error: ' . $e->getMessage();
                exit;
            } catch (\Facebook\Exceptions\FacebookSDKException $e) {
                // When validation fails or other local issues
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }
        
            $me = $response->getGraphUser();
            echo 'Logged in as ' . $me->getName();
        }
    }