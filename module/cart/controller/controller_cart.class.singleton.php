<?php
    class controller_cart {

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
            common::load_view('top_page_cart.php', VIEW_PATH_CART . 'cart.html');
        }

        function load_cart() {
            echo json_encode(common::load_model('cart_model', 'get_load_cart', $_POST['token']));
        }

        function insert_cart() {
            echo json_encode(common::load_model('cart_model', 'get_insert_cart', [$_POST['token'], $_POST['id'], $_POST['qty']]));
        }

        function delete_cart() {
            echo json_encode(common::load_model('cart_model', 'get_delete_cart', [$_POST['token'], $_POST['id']]));
        }

        function update_qty() {
            echo json_encode(common::load_model('cart_model', 'get_update_qty', [$_POST['token'], $_POST['id'], $_POST['qty']]));
        }

        function check_stock_details() {
            echo json_encode(common::load_model('cart_model', 'get_check_stock_details', [$_POST['token'], $_POST['id']]));
        }

        function check_stock() {
            echo json_encode(common::load_model('cart_model', 'get_check_stock',  $_POST['id']));
        }

        function checkout() {
            echo json_encode(common::load_model('cart_model', 'get_checkout', $_POST['token']));
        }
    }
?>