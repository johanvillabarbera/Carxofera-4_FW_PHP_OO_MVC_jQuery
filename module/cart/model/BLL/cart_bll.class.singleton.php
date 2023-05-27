<?php
	class cart_bll {
		private $dao;
		private $db;
		static $_instance;

		function __construct() {
			$this -> dao = cart_dao::getInstance();
			$this -> db = db::getInstance();
		}

		public static function getInstance() {
			if (!(self::$_instance instanceof self)) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function get_insert_cart_BLL($args) {
            $token = middleware::decode_token($args[0]);

            if ($this -> dao -> select_product($this->db, $token['username'], $args[1])) {
				$this -> dao -> update_product($this->db, $token['username'], $args[1], $args[2]);
                return 'update';
			}else{
                $this -> dao -> insert_product($this->db, $token['username'], $args[1], $args[2]);
                return 'insert';
            }
		}

        public function get_delete_cart_BLL($args) {
            $token = middleware::decode_token($args[0]);

            return $this -> dao -> delete_cart($this -> db, $token['username'], $args[1]);
		}

        public function get_update_qty_BLL($args) {
            $token = middleware::decode_token($args[0]);

            return $this -> dao -> update_qty($this -> db, $token['username'], $args[1], $args[2]);
		}

		public function get_load_cart_BLL($args) {
            $token = middleware::decode_token($args);

            $rdo = $this -> dao -> select_user_cart($this -> db, $token['username']);

            if ($rdo) return $rdo;
			else return 'error';
		}

        public function get_check_stock_details_BLL($args) {
            $token = middleware::decode_token($args[0]);

            return $this -> dao -> check_stock_details($this -> db, $token['username'], $args[1]);
		}

        public function get_check_stock_BLL($args) {
            return $this -> dao -> check_stock($this -> db, $args);
		}

		public function get_checkout_BLL($args) {
            $token = middleware::decode_token($args);

			$rdo = $this -> dao -> select_user_cart($this -> db, $token['username']);

            if ($rdo) return $this -> dao -> checkout($this -> db, $rdo, $token['username']);
			else return 'error';
		}
	}
?>