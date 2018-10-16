<?php
    /**
     * Created by DeveloperPro ®.
     * User: Gilberto Guerrero Quinayas
     * Date: 25/09/2018
     * Time: 5:35 PM
     */
    
    namespace Service;


    use Swift_SmtpTransport;
    use Swift_Mailer;
    use Swift_Message;

    /**
     * Class Helpers
     *
     * @package Service
     */
    class Helpers
    {
        /**
         * @var JwtAuth
         */
        public $jwrAuth;
    
        /**
         * Helpers constructor.
         */
        public function __construct()
        {
            $this->jwrAuth = new JwtAuth();
        }
    
        /**
         * @param $request
         *
         * @return false|string
         */
        public function checkCode($request)
        {

            $code = (isset($request['code'])) ? $request['code'] : null;
            $msg = (isset($request['msg'])) ? $request['msg']: null;
            $data = (isset($request['data'])) ? $request['data'] : null;
            $status = (isset($request->status)) ? $request->status : null;

            switch ($code) {
                case '1001':
                    $data = array(
                        'status' => 'success',
                        'code' => $code,
                        'msg' => $msg,
                        'data' => $data
                    );
                    break;
                case '1002':
                    $data = array(
                        'status' => 'Info',
                        'code' => $code,
                        'msg' => $msg,
                        'data' => $data
                    );
                    break;
                case '1003':
                    $data = array(
                        'status' => 'AlertPrimary',
                        'code' => $code,
                        'msg' => $msg,
                        'data' => $data
                    );
                    break;
                case '1004':
                    $data = array(
                        'status' => 'AlertSecondary',
                        'code' => $code,
                        'msg' => $msg,
                        'data' => $data
                    );
                    break;
                case '1005':
                    $data = array(
                        'status' => 'Warning',
                        'code' => $code,
                        'msg' => $msg,
                        'data' => $data
                    );
                    break;
                case '1006':
                    $data = array(
                        'status' => 'Danger',
                        'code' => $code,
                        'msg' => $msg,
                        'data' => $data
                    );
                    break;
                case '1007':
                    $data = array(
                        'status' => 'error',
                        'code' => $code,
                        'msg' => $msg,
                        'data' => $data
                    );
                    break;
                case '1008':
                    $data = array(
                        'status' => 'error',
                        'code' => $code,
                        'msg' => 'Lo sentimos, vuelve a ingresar para ternimar el proceso actual',
                        'data' => $data
                    );
                    break;
                default:
                    die('Lo sentimos el codigo ingresado no existe');
            }
        
            return json_encode($data);
        }
    
        /**
         * @param      $sentName
         * @param      $sentEmail
         * @param      $sentPassword
         * @param      $smtp
         * @param      $port
         * @param      $auth
         * @param      $receivesName
         * @param      $receivesEmail
         * @param      $subjectEmail
         * @param      $bodyEmail
         * @param null $copyEmails
         * @param null $copyNames
         *
         * @return int
         */
        public function sendEmail($sentName, $sentEmail, $sentPassword, $smtp, $port, $auth, $receivesName, $receivesEmail, $subjectEmail, $bodyEmail, $copyEmails = null, $copyNames = null)
        {
            $transport = (new Swift_SmtpTransport($smtp, $port, $auth))
                ->setUsername($sentEmail)
                ->setPassword($sentPassword)
                ->setStreamOptions(array(
                        'ssl' => array(
                            'allow_self_signed' => true, 'verify_peer' => false
                        )
                    )
                );
        
            $mailer = new Swift_Mailer($transport);
        
            if ($copyEmails)
                $message = (new Swift_Message($subjectEmail))
                    ->setFrom([$sentEmail => $sentName])
                    ->setTo([$receivesEmail => $receivesName])
                    ->setCc([$copyEmails => $copyNames])
                    ->setBody($bodyEmail, 'text/html');
            else
                $message = (new Swift_Message($subjectEmail))
                    ->setFrom([$sentEmail => $sentName])
                    ->setTo([$receivesEmail => $receivesName])
                    ->setBody($bodyEmail, 'text/html');
        
            $result = $mailer->send($message);
        
            return $result;
        }
    
        /**
         * @param $email
         *
         * @return bool
         */
        public function isValidEmail($email)
        {
            $result = (false !== filter_var($email, FILTER_VALIDATE_EMAIL));
        
            if ($result) {
                list($user, $domain) = explode('@', $email);
            
                $result = checkdnsrr($domain, 'MX');
            }
        
            return $result;
        }
    
        /**
         * @param $data
         *
         * @return false|mixed|string
         */
        public function jsonEncodeDecode($data)
        {
            $data = json_encode($data);
            $data = json_decode($data);
        
            return $data;
        }
    
        /**
         * @param $min
         * @param $max
         *
         * @return int
         * @throws \Exception
         */
        public function codeGenerate($min, $max)
        {
            return random_int($min, $max);
        }
    }