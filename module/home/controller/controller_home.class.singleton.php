<?php
    class controller_home {

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
            common::load_view('top_page_home.php', VIEW_PATH_HOME . 'home.html');
        }

        function carouselBrands() {
            echo json_encode(common::load_model('home_model', 'get_carouselBrands'));
        }

        function category() {
            echo json_encode(common::load_model('home_model', 'get_category'));
        }
        
        function type() {
            echo json_encode(common::load_model('home_model', 'get_type'));
        }

        function carouselVisits() {
            echo json_encode(common::load_model('home_model', 'get_carouselVisits'));
        }
    }
?>