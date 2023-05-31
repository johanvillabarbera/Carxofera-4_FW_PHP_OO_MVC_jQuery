<?php

	class login_bll {
		
		private $dao;
		private $db;
		static $_instance;

		function __construct() {
			$this -> dao = login_dao::getInstance();
			$this -> db = db::getInstance();
		}

		public static function getInstance() {
			if (!(self::$_instance instanceof self)) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

        public function get_register_BLL($args) {
            if($this -> dao -> select_username($this->db, $args[0])){
				return 'error_username';
			}

            if($this -> dao -> select_email($this->db, $args[1])){
				return 'error_email';
			}
			
			$hashed_pass = password_hash($args[2], PASSWORD_DEFAULT, ['cost' => 12]);
            $hashavatar = md5(strtolower(trim($args[1]))); 
            $avatar = "https://i.pravatar.cc/500?u=$hashavatar";
			$token_email = common::generate_Token_secure(20);

            $this -> dao -> insert_user($this->db, $args[0], $args[1], $hashed_pass, $avatar, $token_email);
			$message = [ 'type' => 'validate', 
						'token' => $token_email, 
						'toEmail' =>  $args[0]];
			$email = json_decode(mail::send_email($message), true);
			if (!empty($email)) {
				return;  
			}
		}

		public function get_login_BLL($args) {

			if (!empty($this -> dao -> select_user($this->db, $args[0]))) {
				$user = $this -> dao -> select_user($this->db, $args[0]);
				if (password_verify($args[1], $user[0]['password']) && $user[0]['activate'] == 1) {
					$token[0]= middleware::create_token($user[0]['username']);
					$token[1]= middleware::create_token_refresh($user[0]['username']);
					$_SESSION['username'] = $user[0]['username']; //Guardamos el usuario 
					$_SESSION['tiempo'] = time(); //Guardamos el tiempo que se logea
					return $token;
				} else if (password_verify($args[1], $user[0]['password']) && $user[0]['activate'] == 0){
					return 'error_verify';
				} else {
					return 'error_password';
				}
            } else {
				return 'error_user';
			}
		}

		public function get_logout_BLL(){
			unset($_SESSION['username']);
			unset($_SESSION['tiempo']);
			session_destroy();

			return 'Done';
		}

		public function get_social_login_BLL($args) {
			if (!empty($this -> dao -> select_user_social($this->db, $args[1], $args[2]))) {
				$user = $this -> dao -> select_user_social($this->db, $args[1], $args[2]);
				$token[0]= middleware::create_token($user[0]['username']);
				$token[1]= middleware::create_token_refresh($user[0]['username']);
				$_SESSION['username'] = $user[0]['username']; //Guardamos el usuario 
				$_SESSION['tiempo'] = time(); //Guardamos el tiempo que se logea
				return $token;
            } else {
				$this -> dao -> insert_social_login($this->db, $args[0], $args[1], $args[2], $args[3]);
				$user = $this -> dao -> select_user_social($this->db, $args[1], $args[2]);
				$token[0]= middleware::create_token($user[0]['username']);
				$token[1]= middleware::create_token_refresh($user[0]['username']);
				$_SESSION['username'] = $user[0]['username']; //Guardamos el usuario 
				$_SESSION['tiempo'] = time(); //Guardamos el tiempo que se logea
				return $token;
			}
		}

		public function get_verify_email_BLL($args) {

			if($this -> dao -> select_verify_email($this->db, $args)){
				$this -> dao -> update_verify_email($this->db, $args);
				return 'verify';
			} else {
				return 'fail';
			}
		}

		public function get_recover_email_BBL($args) {
			$user = $this -> dao -> select_recover_password($this->db, $args);
			$token = common::generate_Token_secure(20);

			if (!empty($user)) {
				$this -> dao -> update_recover_password($this->db, $args, $token);
                $message = ['type' => 'recover', 
                            'token' => $token, 
                            'toEmail' => $args];
                $email = json_decode(mail::send_email($message), true);
				if (!empty($email)) {
					return;  
				}   
            }else{
                return 'error';
            }
		}

		public function get_verify_token_BLL($args) {

			if($this -> dao -> select_verify_email($this->db, $args)){
				return 'verify';
			}
			return 'fail';
		}

		public function get_new_password_BLL($args) {
			$hashed_pass = password_hash($args[1], PASSWORD_DEFAULT, ['cost' => 12]);
			if($this -> dao -> update_new_password($this->db, $args[0], $hashed_pass)){
				return 'done';
			}
			return 'fail';
		}

		public function get_data_user_BLL($args) {
			$token = middleware::decode_token($args);

			return $this -> dao -> select_data_user($this->db, $token['username']);
		}


		public function get_activity_BLL() {
			if (!isset($_SESSION["tiempo"])) return "inactivo";
			else {
				if ((time() - $_SESSION["tiempo"]) >= 1800) return "inactivo"; //1800s=30min
				else "activo";
			}
		}

		public function get_controluser_BLL($args) {
			$token_dec = middleware::decode_token($args);
			
			if ($token_dec['exp'] < time()) return "Wrong_User";
	
			if (isset($_SESSION['username']) && ($_SESSION['username']) == $token_dec['username']) return "Correct_User";
			else "Wrong_User";
		}

		public function get_refresh_token_BLL($args) {
			$old_token = middleware::decode_token($args[0]);
			$old_token_refresh = middleware::decode_token($args[1]);
	
			if ($old_token_refresh['exp'] < time()) {
				$new_token = middleware::create_token_refresh($old_token['username']);
				return $new_token;
			}else return "No_Refresh";
		}

		public function get_token_expires_BLL($args) {

			$token = explode('"', $args);
			$decode = middleware::decode_exp($token[1]);
			
            if(time() >= $decode) {  
				return "inactivo"; 
			} else{
				return "activo";
			}
		}
	}