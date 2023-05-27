<?php
	class home_bll {
		private $dao;
		private $db;
		static $_instance;

		function __construct() {
			$this -> dao = home_dao::getInstance();
			$this -> db = db::getInstance();
		}

		public static function getInstance() {
			if (!(self::$_instance instanceof self)) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function get_carouselBrands_BLL() {
			return $this -> dao -> select_data_brand($this -> db);
		}

		public function get_category_BLL() {
			return $this -> dao -> select_data_category($this -> db);
		}

		public function get_type_BLL() {
			return $this -> dao -> select_data_type($this -> db);
		}

		public function get_carouselVisits_BLL() {
			return $this -> dao -> select_data_carousel_visits($this -> db);
		}
	}
?>