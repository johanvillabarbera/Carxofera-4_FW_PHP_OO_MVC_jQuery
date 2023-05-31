<?php
    class login_dao {
        static $_instance;

        private function __construct() {
        }

        public static function getInstance() {
            if(!(self::$_instance instanceof self)){
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        function select_username($db, $username){
			$sql = "SELECT username 
                    FROM users 
                    WHERE username='$username'";
			
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
		}

        function select_email($db, $email){
			$sql = "SELECT email 
                    FROM users 
                    WHERE email='$email'";
			
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
		}

        function insert_user($db, $username, $email, $hashed_pass, $avatar, $token_email){
            $sql ="INSERT INTO `users`(`username`, `password`, `email`, `type_user`, `avatar`, `activate`, `token_email`) 
                    VALUES ('$username','$hashed_pass','$email','client','$avatar', 0, '$token_email')";

            return $stmt = $db->ejecutar($sql);
        }

        function select_user($db, $username){
			$sql = "SELECT `username`, `password`, `email`, `type_user`, `avatar`, `activate` 
                    FROM `users` 
                    WHERE username='$username'";
            
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        function select_user_social($db, $username, $email){
			$sql = "SELECT `username`, `password`, `email`, `type_user`, `avatar`, `activate` 
                    FROM `users` 
                    WHERE username='$username' 
                    OR email='$email'";
            
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        public function select_social_login($db, $id){
			$sql = "SELECT * 
                    FROM users 
                    WHERE id='$id'";
            $stmt = $db->ejecutar($sql);

            return $db->listar($stmt);
        }

        public function insert_social_login($db, $id, $username, $email, $avatar){
            $sql ="INSERT INTO users (id_user, username, password, email, type_user, avatar, token_email, activate)     
                    VALUES ('$id', '$username', '', '$email', 'client', '$avatar', '', 1)";

            return $stmt = $db->ejecutar($sql);
        }

        public function select_verify_email($db, $token_email){
			$sql = "SELECT token_email 
                    FROM users 
                    WHERE token_email = '$token_email'";

            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        } 

        public function update_verify_email($db, $token_email){
            $sql = "UPDATE users 
                    SET activate = 1, token_email= '' 
                    WHERE token_email = '$token_email'";

            $stmt = $db->ejecutar($sql);
            return "update";
        }

        public function select_recover_password($db, $email){
			$sql = "SELECT `email` 
                    FROM `users` 
                    WHERE email = '$email' 
                    AND password NOT LIKE ('')";
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        public function update_recover_password($db, $email, $token_email){
			$sql = "UPDATE `users` 
                    SET `token_email`= '$token_email' 
                    WHERE `email` = '$email'";
            $stmt = $db->ejecutar($sql);
            return "ok";
        }

        public function update_new_password($db, $token_email, $password){
            $sql = "UPDATE `users` 
                    SET `password`= '$password', `token_email`= '' 
                    WHERE `token_email` = '$token_email'";
            $stmt = $db->ejecutar($sql);
            return "ok";
        }

        function select_data_user($db, $username){
			$sql = "SELECT * 
                    FROM users 
                    WHERE username='$username'";
			
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

    }

?>