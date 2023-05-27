<?php
    class mail {
        public static function send_email($email) {
            switch ($email['type']) {
                case 'contact';
                    $email['toEmail'] = 'axuelputoamo@gmail.com';
                    $email['fromEmail'] = 'johanvillabarbera@gmail.com';
                    $email['inputEmail'] = 'johanvillabarbera@gmail.com';
                    $email['inputSubject'] = 'Email verification';
                    $email['inputMessage'] = "yeyeyeyeyeyeyeyeyeyeyeyeyeyeyyeyeyeyeyeyeyeyeyey";
                    break;
                case 'validate';
                    $email['toEmail'] = 'axuelputoamo@gmail.com';
                    $email['fromEmail'] = 'johanvillabarbera@gmail.com';
                    $email['inputEmail'] = 'johanvillabarbera@gmail.com';
                    $email['inputSubject'] = 'Email verification';
                    $email['inputMessage'] = "<h2>Email verification.</h2><a href='http://localhost/4_FW_PHP_OO_MVC_jQuery_v2/login/view/verify/$email[token]'>Click here for verify your email.</a>";
                    break;
                case 'recover';
                    $email['toEmail'] = 'axuelputoamo@gmail.com';
                    $email['fromEmail'] = 'johanvillabarbera@gmail.com';
                    $email['inputEmail'] = 'johanvillabarbera@gmail.com';
                    $email['inputSubject'] = 'Recover password';
                    $email['inputMessage'] = "<a href='http://localhost/4_FW_PHP_OO_MVC_jQuery_v2/login/view/recover/$email[token]'>Click here for recover your password.</a>";
                    break;
            }
            return self::send_mailgun($email);
        }

        public static function send_mailgun($values){
            $mailgun = parse_ini_file(MODEL_PATH . "credentials.ini", true);
            $api_key = $mailgun['mailgun']['api_key'];
            $api_url = $mailgun['mailgun']['api_url'];

            $config = array();
            $config['api_key'] = $api_key; 
            $config['api_url'] = $api_url;

            $message = array();
            $message['from'] = $values['fromEmail'];
            $message['to'] = $values['toEmail'];
            $message['h:Reply-To'] = $values['inputEmail'];
            $message['subject'] = $values['inputSubject'];
            $message['html'] = $values['inputMessage'];
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $config['api_url']);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, "api:{$config['api_key']}");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$message);
            $result = curl_exec($ch);
            curl_close($ch);
            return $result;
        }
    }