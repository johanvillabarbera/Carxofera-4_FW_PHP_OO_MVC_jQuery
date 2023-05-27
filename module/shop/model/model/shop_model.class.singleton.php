<?php
    class shop_model {

        private $bll;
        static $_instance;

        function __construct() {
            $this -> bll = shop_bll::getInstance();
        }

        public static function getInstance() {
            if (!(self::$_instance instanceof self)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function get_list($args) {
            return $this -> bll -> get_list_BLL($args);
        }

        public function get_details($args) {
            return $this -> bll -> get_details_BLL($args);
        }

        public function get_load_filters() {
            return $this -> bll -> get_load_filters_BLL();
        }

        public function get_filters($args) {
            return $this -> bll -> get_filters_BLL($args);
        }

        public function get_cars_related($args) {
            return $this -> bll -> get_cars_related_BLL($args);
        }

        public function get_count_cars_related($args) {
            return $this -> bll -> get_count_cars_related_BLL($args);
        }

        public function get_count_cars_all() {
            return $this -> bll -> get_count_cars_all_BLL();
        }

        public function get_count_cars_filter($args) {
            return $this -> bll -> get_count_cars_filter_BLL($args);
        }

        public function get_count_cars_filter_search($args) {
            return $this -> bll -> get_count_cars_filter_search_BLL($args);
        }

        public function get_control_likes($args) {
            return $this -> bll -> get_control_likes_BLL($args);
        }

        public function get_load_likes($args) {
            return $this -> bll -> get_load_likes_BLL($args);
        }
        
        public function get_filters_search($args) {
            return $this -> bll -> get_filters_search_BLL($args);
        }

        public function get_filters_sort_by($args) {
            return $this -> bll -> get_filters_sort_by_BLL($args);
        }

        // public function get_most_visit($args) {
        //     return $this -> bll -> get_most_visit_BLL($args);
        // }

        // public function get_count() {
        //     return $this -> bll -> get_count_BLL();
        // }

        // public function get_count_filters($args) {
        //     return $this -> bll -> get_count_filters_BLL($args);
        // }

        // public function get_cars($args) {
        //     return $this -> bll -> get_cars_BLL($args);
        // }
    }
?>
