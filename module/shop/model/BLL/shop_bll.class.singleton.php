<?php
	class shop_bll {
		private $dao;
		private $db;
		static $_instance;

		function __construct() {
			$this -> dao = shop_dao::getInstance();
			$this -> db = db::getInstance();
		}

		public static function getInstance() {
			if (!(self::$_instance instanceof self)) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

        public function get_list_BLL($args) {
			return $this -> dao -> select_all_cars($this->db, $args[0], $args[1]);
		}

        public function get_details_BLL($args) {
			return $this -> dao -> select_details_images($this->db, $args);
		}

		public function get_load_filters_BLL() {
			return $this -> dao -> select_load_filters($this->db);
		}

		public function get_filters_BLL($args) {
			return $this -> dao -> select_filters($this->db, $args[0], $args[1], $args[2]);
		}

		public function get_cars_related_BLL($args) {
			if($this -> dao -> select_cars_related($this->db, $args[0], $args[1], $args[2], $args[3])){
				return $this -> dao -> select_cars_related($this->db, $args[0], $args[1], $args[2], $args[3]);
			}else{
				return 'error';
			}
			
		}

		public function get_count_cars_related_BLL($args) {
			return $this -> dao -> select_count_cars_related($this->db, $args[0], $args[1]);
		}

		public function get_count_cars_all_BLL() {
			return $this -> dao -> select_count_cars_all($this->db);
		}

		public function get_count_cars_filter_BLL($args) {
			return $this -> dao -> select_count_cars_filter($this->db, $args);
		}

		public function get_count_cars_filter_search_BLL($args) {
			$all_search = $args;
			$city = ($all_search[0]);
			$model = ($all_search[1]);
			$brand = ($all_search[2]);
	
			if (($model[1] != "0") && ($brand[1] == "0") && ($city[1] == "0")) {
				$rdo_array[0] = $model;
				$rdo = $this -> dao -> select_count_cars_filter($this->db, $rdo_array);
			}else if (($model[1] == "0") && ($brand[1] != "0") && ($city[1] == "0")) {
				$rdo_array[0] = $brand;
				$rdo = $this -> dao -> select_count_cars_filter($this->db, $rdo_array);
			} else if (($model[1] == "0") && ($brand[1] == "0") && ($city[1] != "0")) {
				$rdo_array[0] = $city;
				$rdo = $this -> dao -> select_count_cars_filter($this->db, $rdo_array);
			} else if (($model[1] != "0") && ($brand[1] != "0") && ($city[1] == "0")) {
				$rdo_array[0] = $model;
				$rdo_array[1] = $brand;
				$rdo = $this -> dao -> select_count_cars_filter($this->db, $rdo_array);
			} else if (($model[1] == "0") && ($brand[1] != "0") && ($city[1] != "0")) {
				$rdo_array[0] = $brand;
				$rdo_array[1] = $city;
				$rdo = $this -> dao -> select_count_cars_filter($this->db, $rdo_array);
			} else if (($model[1] != "0") && ($brand[1] == "0") && ($city[1] != "0")) {
				$rdo_array[0] = $model;
				$rdo_array[1] = $city;
				$rdo = $this -> dao -> select_count_cars_filter($this->db, $rdo_array);
			} else if (($model[1] != "0") && ($brand[1] != "0") && ($city[1] != "0")) {
				$rdo_array[0] = $model;
				$rdo_array[1] = $brand;
				$rdo_array[2] = $city;
				$rdo = $this -> dao -> select_count_cars_filter($this->db, $rdo_array);
			} else {
				$rdo = $this -> dao -> select_count_cars_all($this->db);
			}

			return $rdo;
		}

		public function get_control_likes_BLL($args) {
			$token = middleware::decode_token($args[1]);

			if ($this -> dao -> select_control_likes($this->db, $args[0], $token['username'])) {
				return 'ok';
			}
			return 'error';
		}

		public function get_load_likes_BLL($args) {
			$token = middleware::decode_token($args);

			return $this -> dao -> select_load_likes($this->db, $token['username']);
		}

		public function get_filters_search_BLL($args) {
			$all_search = $args[0];
			$city = ($all_search[0]);
			$model = ($all_search[1]);
			$brand = ($all_search[2]);
			$prod = $args[1];
			$items = $args[2];
	
			if (($model[1] != "0") && ($brand[1] == "0") && ($city[1] == "0")) {
				$rdo_array[0] = $model;
				$rdo = $this -> dao -> select_filters($this->db, $rdo_array, $prod, $items);
			}else if (($model[1] == "0") && ($brand[1] != "0") && ($city[1] == "0")) {
				$rdo_array[0] = $brand;
				$rdo = $this -> dao -> select_filters($this->db, $rdo_array, $prod, $items);
			} else if (($model[1] == "0") && ($brand[1] == "0") && ($city[1] != "0")) {
				$rdo_array[0] = $city;
				$rdo = $this -> dao -> select_filters($this->db, $rdo_array, $prod, $items);
			} else if (($model[1] != "0") && ($brand[1] != "0") && ($city[1] == "0")) {
				$rdo_array[0] = $model;
				$rdo_array[1] = $brand;
				$rdo = $this -> dao -> select_filters($this->db, $rdo_array, $prod, $items);
			} else if (($model[1] == "0") && ($brand[1] != "0") && ($city[1] != "0")) {
				$rdo_array[0] = $brand;
				$rdo_array[1] = $city;
				$rdo = $this -> dao -> select_filters($this->db, $rdo_array, $prod, $items);
			} else if (($model[1] != "0") && ($brand[1] == "0") && ($city[1] != "0")) {
				$rdo_array[0] = $model;
				$rdo_array[1] = $city;
				$rdo = $this -> dao -> select_filters($this->db, $rdo_array, $prod, $items);
			} else if (($model[1] != "0") && ($brand[1] != "0") && ($city[1] != "0")) {
				$rdo_array[0] = $model;
				$rdo_array[1] = $brand;
				$rdo_array[2] = $city;
				$rdo = $this -> dao -> select_filters($this->db, $rdo_array, $prod, $items);
			} else {
				$rdo = $this -> dao -> select_all_cars($this->db, $prod, $items);
			}

			return $rdo;
		}

		public function get_filters_sort_by_BLL($args) {
			return $this -> dao -> select_filters_sort_by($this->db, $args[0], $args[1], $args[2]);
		}

		// public function get_most_visit_BLL($args) {
		// 	return $this -> dao -> update_view($this->db, $args[0]);
		// }
		
		// public function get_count_BLL() {
		// 	return $this -> dao -> select_count($this->db);
		// }

		// public function get_count_filters_BLL($args) {
		// 	return $this -> dao -> select_count_filters($this->db, json_decode($args));
		// }

		// public function get_cars_BLL($args) {
		// 	return $this -> dao -> select_cars($this->db, $args[0], $args[1], $args[2], $args[3], $args[4]);
		// }
	}
?>