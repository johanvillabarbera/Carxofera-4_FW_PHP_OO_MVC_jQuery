<?php
    class controller_shop {

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
            common::load_view('top_page_shop.php', VIEW_PATH_SHOP . 'shop.html');
        }

        function list() {
            echo json_encode(common::load_model('shop_model', 'get_list', [$_POST['total_prod'], $_POST['items_page']]));
        }
        
        function details() {
            echo json_encode(common::load_model('shop_model', 'get_details', $_GET['id']));
        }
        
        function load_filters() {
            echo json_encode(common::load_model('shop_model', 'get_load_filters'));
        }

        function filters() {
            echo json_encode(common::load_model('shop_model', 'get_filters', [$_POST['filter'], $_POST['total_prod'], $_POST['items_page']]));
        }

        function cars_related() {
            echo json_encode(common::load_model('shop_model', 'get_cars_related', [$_POST['brand'], $_POST['id_car'], $_POST['loaded'], $_POST['items']]));
        }

        function count_cars_related() {
            echo json_encode(common::load_model('shop_model', 'get_count_cars_related', [$_POST['name_brand'], $_POST['id_car']]));
        }

        function count_cars_all() {
            echo json_encode(common::load_model('shop_model', 'get_count_cars_all'));
        }

        function count_cars_filter() {
            echo json_encode(common::load_model('shop_model', 'get_count_cars_filter', $_POST['filter']));
        }

        function count_cars_filter_search() {
            echo json_encode(common::load_model('shop_model', 'get_count_cars_filter_search', $_POST['filter']));
        }

        function control_likes() {
            echo json_encode(common::load_model('shop_model', 'get_control_likes', [$_POST['id_car'], $_POST['token']]));
        }

        function load_likes() {
            echo json_encode(common::load_model('shop_model', 'get_load_likes', $_POST['token']));
        }
        
        function filters_search() {
            echo json_encode(common::load_model('shop_model', 'get_filters_search', [$_POST['filter'], $_POST['total_prod'],$_POST['items_page']]));
        }

        function filters_sort_by() {
            echo json_encode(common::load_model('shop_model', 'get_filters_sort_by', [$_POST['filter'], $_POST['total_prod'], $_POST['items_page']]));
        }

        // function most_visit() {
        //     echo json_encode(common::load_model('shop_model', 'get_most_visit_BLL', $_POST['id']));
        // }

        // function count() {
        //     echo json_encode(common::load_model('shop_model', 'get_count'));
        // }

        // function count_filters() {
        //     echo json_encode(common::load_model('shop_model', 'get_count_filters', $_POST['filters']));
        // }

        // function cars() {
        //     // echo json_encode('Hola');
        //     echo json_encode(common::load_model('shop_model', 'get_cars', [$_POST['category'], $_POST['type'], $_POST['id'], $_POST['loaded'], $_POST['items']]));
        // }

    }
?>
