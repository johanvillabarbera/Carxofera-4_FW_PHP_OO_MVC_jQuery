<?php
    class controller_login {

        static $_instance;

		function __construct() {
		}

		public static function getInstance() {
			if (!(self::$_instance instanceof self)) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

        function view() {
            common::load_view('top_page_login.php', VIEW_PATH_LOGIN . 'login.html');
        }

        function recover_view() {
            common::load_view('top_page_login.php', VIEW_PATH_LOGIN . 'login.html');
        }
    
        function login() {
            echo json_encode(common::load_model('login_model', 'get_login', [$_POST['username_log'], $_POST['password_log']]));
        }

        function register() {
            echo json_encode(common::load_model('login_model', 'get_register', [$_POST['username_reg'], $_POST['email_reg'], $_POST['password_reg1']]));
        }

        // function social_login() {
        //     // echo json_encode($_POST['id']);
        //     echo json_encode(common::load_model('login_model', 'get_social_login', [$_POST['id'], $_POST['username'], $_POST['email'], $_POST['avatar']]));
        // } 
    
        function verify_email() {
            $verify = json_encode(common::load_model('login_model', 'get_verify_email', $_POST['token_email']));
            echo json_encode($verify);
        }

        function send_recover_email() {
            echo json_encode(common::load_model('login_model', 'get_recover_email', $_POST['email_recover']));
        }

        function verify_token() {
            echo json_encode(common::load_model('login_model', 'get_verify_token', $_POST['token_email']));
        }

        function new_password() {
            // echo json_encode([$_POST['token_email'], $_POST['password']]);
            echo json_encode(common::load_model('login_model', 'get_new_password', [$_POST['token_email'], $_POST['password']]));
            // if (!empty($password)) {
            //     echo $password;
            //     return;
            // }
        }  
    
        function logout() {
            echo json_encode(common::load_model('login_model', 'get_logout'));
        } 

        function data_user() {
            echo json_encode(common::load_model('login_model', 'get_data_user', $_POST['token']));
        }

        function activity() {
            echo json_encode(common::load_model('login_model', 'get_activity'));
        }

        function controluser() {
            echo json_encode(common::load_model('login_model', 'get_controluser', $_POST['token']));
        }

        function refresh_token() {
            echo json_encode(common::load_model('login_model', 'get_refresh_token', [$_POST['token'], $_POST['token_refresh']]));
        } 
        
        // function token_expires() {
        //     echo json_encode(common::load_model('login_model', 'get_token_expires', $_POST['token']));
        // }

        function refresh_cookie() {
            session_regenerate_id();
            echo json_encode("Done");
        } 
    
    }
    
?>