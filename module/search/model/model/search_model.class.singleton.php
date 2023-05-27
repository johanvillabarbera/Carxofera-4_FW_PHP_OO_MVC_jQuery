<?php
    class search_model {
        private $bll;
        static $_instance;
        
        function __construct() {
            $this -> bll = search_bll::getInstance();
        }

        public static function getInstance() {
            if (!(self::$_instance instanceof self)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function get_select_model() {
            return $this -> bll -> get_select_model_BLL();
        }

        public function get_select_model_brand($args) {
            return $this -> bll -> get_select_model_brand_BLL($args);
        }

        public function get_select_brand() {
            return $this -> bll -> get_select_brand_BLL();
        }

        public function get_select_auto_model($args) {
            return $this -> bll -> get_select_auto_model_BLL($args);
        }

        public function get_select_auto_model_brand($args) {
            return $this -> bll -> get_select_auto_model_brand_BLL($args);
        }

        public function get_select_auto_brand($args) {
            return $this -> bll -> get_select_auto_brand_BLL($args);
        }

        public function get_select_auto($args) {
            return $this -> bll -> get_select_auto_BLL($args);
        }

        public function get_car_type() {
            return $this -> bll -> get_car_type_BLL();
        }

        public function get_car_brand() {
            return $this -> bll -> get_car_brand_BLL();
        }

        public function get_car_type_brand($args) {
            return $this -> bll -> get_car_type_brand_BLL($args);
        }

        public function get_auto_car_type($args) {
            return $this -> bll -> get_auto_car_type_BLL($args);
        }

        public function get_auto_car_brand($args) {
            return $this -> bll -> get_auto_car_brand_BLL($args);
        }

        public function get_auto_car_type_brand($args) {
            return $this -> bll -> get_auto_car_type_brand_BLL($args);
        }

        public function get_auto($args) {
            return $this -> bll -> get_auto_BLL($args);
        }

    }