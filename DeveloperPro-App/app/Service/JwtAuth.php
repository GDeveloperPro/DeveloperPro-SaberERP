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
        public function signIn($email, $password, $getHash = false)
        {
            $helper = new Helpers();
            $connection = new Connections();
        
            $sqlQueryUser = "SELECT se_user_id, se_user_email, se_user_password, se_user_code, se_user_last_connection, se_user_created_at, se_user_state_type, se_user_state, se_user_google_id, se_user_twitter_id, se_user_facebook_id, se_role_id_fk, se_group_id_fk,
                                    se_profile_id, se_profile_identification, se_profile_name, se_profile_surname, se_profile_image, se_profile_birthdate, se_profile_address, se_profile_phone, se_profile_phone_cell, se_profile_state, co_city_id_fk, se_user_id_fk
                                FROM security.se_users seu INNER JOIN security.se_profiles sep ON seu.se_user_id = sep.se_user_id_fk WHERE se_user_email = '$email';";
            $resultQueryUser = $connection->complexQueryNonAssociative($sqlQueryUser);
        
            if ($resultQueryUser && $resultQueryUser > 0) {
                $resultQueryUser = $helper->jsonEncodeDecode($resultQueryUser);
            
                $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
                $pv = password_verify($password, $resultQueryUser->se_user_password);
            
                if (!$pv) {
                    $token = array(
                        'iss' => getenv('APP_ISS'),
                        'sub' => base64_encode($resultQueryUser->se_user_id),
                        'subgmailid' => (isset($resultQueryUser->se_user_google_id)) ? base64_encode($resultQueryUser->se_user_google_id) : null,
                        'subtwitterid' => (isset($resultQueryUser->se_user_twitter_id)) ? base64_encode($resultQueryUser->se_user_twitter_id) : null,
                        'subfacebookid' => (isset($resultQueryUser->se_user_facebook_id)) ? base64_encode($resultQueryUser->se_user_facebook_id) : null,
                        'email' => base64_encode($resultQueryUser->se_user_email),
                        'name' => base64_encode($resultQueryUser->se_profile_name),
                        'surname' => base64_encode($resultQueryUser->se_profile_surname),
                        'image' => (isset($resultQueryUser->se_profile_image)) ? base64_encode($resultQueryUser->se_profile_image) : null,
                        'iat' => time(),
                        'nbf' => time(),
                        'exp' => time() + (12 * 60 * 60)
                    );
                
                    $jwt = JWT::encode($token, $this->key, 'HS512');
                    $decoded = JWT::decode($jwt, $this->key, array('HS512'));
                
                    if ($getHash)
                        return $jwt;
                    else
                        return $decoded;
                } else {
                    $data = array(
                        'code' => '1005',
                        'msg' => 'Password incorrect'
                    );
                }
            } else {
                $data = array(
                    'code' => '1005',
                    'msg' => 'User not exist'
                );
            }
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