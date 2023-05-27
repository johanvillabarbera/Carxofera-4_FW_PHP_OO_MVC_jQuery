<?php
    class controller_search {
        static $_instance;

		function __construct() {
		}

		public static function getInstance() {
			if (!(self::$_instance instanceof self)) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

        function select_model() {
            echo json_encode(common::load_model('search_model', 'get_select_model'));
        }

        function select_model_brand() {
            echo json_encode(common::load_model('search_model', 'get_select_model_brand', $_POST['brand']));
        }

        function select_brand() {
            echo json_encode(common::load_model('search_model', 'get_select_brand'));
        }

        function car_type() {
            echo json_encode(common::load_model('search_model', 'get_car_type'));
        }

        function car_brand() {
            if(empty($_POST['car_type'])){
                echo json_encode(common::load_model('search_model', 'get_car_brand'));
            }else{
                echo json_encode(common::load_model('search_model', 'get_car_type_brand', $_POST['car_type']));
            }
        }
        
        function autocomplete() {
            // if (!empty($_POST['car_type']) && empty($_POST['car_brand'])){
            //     echo json_encode(common::load_model('search_model', 'get_auto_car_type', [$_POST['car_type'], $_POST['complete']]));
            // }else if(empty($_POST['car_type']) && !empty($_POST['categoria'])){
            //     echo json_encode(common::load_model('search_model', 'get_auto_car_brand', [$_POST['car_brand'], $_POST['complete']]));
            // }else if(!empty($_POST['car_type']) && !empty($_POST['car_brand'])){
            //     echo json_encode(common::load_model('search_model', 'get_auto_car_type_brand', [$_POST['car_type'], $_POST['car_brand'], $_POST['complete']]));
            // }else {
            //     echo json_encode(common::load_model('search_model', 'get_auto', $_POST['complete']));
            // }


            if (!empty($_POST['name_model']) && empty($_POST['name_brand'])) {         
                echo json_encode(common::load_model('search_model', 'get_select_auto_model', [$_POST['name_city'], $_POST['name_model']]));   
            } else if (!empty($_POST['name_model']) && !empty($_POST['name_brand'])) {
                echo json_encode(common::load_model('search_model', 'get_select_auto_model_brand', [$_POST['name_city'], $_POST['name_model'], $_POST['name_brand']]));   
            } else if (empty($_POST['name_model']) && !empty($_POST['name_brand'])) {
                echo json_encode(common::load_model('search_model', 'get_select_auto_brand', [$_POST['name_city'], $_POST['name_brand']]));   
            } else {
                echo json_encode(common::load_model('search_model', 'get_select_auto', $_POST['name_city']));   
            }
        }
    }
?>