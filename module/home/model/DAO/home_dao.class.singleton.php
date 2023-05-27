<?php
    class home_dao {
        static $_instance;

        private function __construct() {
        }

        public static function getInstance() {
            if(!(self::$_instance instanceof self)){
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function select_data_brand($db) {

            $sql = "SELECT * FROM brand";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
        }

        public function select_data_category($db) {

            $sql = "SELECT * FROM category";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
        }

        public function select_data_type($db) {

            $sql = "SELECT * FROM motor_type";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
        }

        public function select_data_carousel_visits($db) {

            $sql = "SELECT c.*, b.name_brand , m.name_model , st.name_tshift , c2.name_color , ic.name_img, ft.name_frame, mt.name_tmotor
                    FROM car c, brand b , model m , shift_type st , color c2 , img_cars ic , frame_type ft, motor_type mt
                    WHERE c.id_model = m.id_model 
                    AND m.id_brand = b.id_brand 
                    AND c.id_tshift = st.id_tshift 
                    AND c.id_color = c2.id_color 
                    AND ic.id_car = c.id_car
                    AND c.id_frame = ft.id_frame 
                    AND c.id_tmotor = mt.id_tmotor
                    GROUP BY c.id_car
                    ORDER BY c.count_visited DESC";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
        }

    }
?>