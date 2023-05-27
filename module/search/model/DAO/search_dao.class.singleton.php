<?php
    class search_dao{
        static $_instance;

        private function __construct() {
        }
    
        public static function getInstance() {
            if(!(self::$_instance instanceof self)){
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        function select_model($db){
			$sql = "SELECT DISTINCT * FROM model";

			$stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        function select_model_brand($db, $brand){
            $sql = "SELECT DISTINCT m.*
            FROM car c , model m , brand b 
            WHERE c.id_model = m.id_model AND b.id_brand = m.id_brand 
            and b.name_brand = '$brand'";

            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        function select_brand($db){
            $sql = "SELECT DISTINCT * FROM brand";

			$stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }
        
        function select_car_type($db){

			$sql = "SELECT DISTINCT type_name FROM type";

			$stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        function select_car_brand($db){

            $sql = "SELECT DISTINCT brand_name FROM brand";

			$stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        function select_auto_model($db, $auto, $model){
            $sql = "SELECT DISTINCT c2.*
                    FROM car c, city c2 , model m 
                    WHERE c.id_city = c2.id_city AND m.id_model = c.id_model 
                    AND m.name_model LIKE '$model'
                    AND c2.name_city LIKE '$auto%'";

            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        function select_auto_model_brand($db, $auto, $model, $brand){
            $sql = "SELECT DISTINCT c2.*
                    FROM car c, city c2 , model m , brand b 
                    WHERE c.id_city = c2.id_city AND m.id_model = c.id_model AND b.id_brand = m.id_brand 
                    AND b.name_brand LIKE '$brand'
                    AND m.name_model LIKE '$model'
                    AND c2.name_city LIKE '$auto%'";

            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        function select_auto_brand($db, $auto, $brand){
            $sql = "SELECT DISTINCT c2.*
                    FROM car c, city c2 , model m , brand b 
                    WHERE c.id_city = c2.id_city AND m.id_model = c.id_model AND b.id_brand = m.id_brand 
                    AND b.name_brand LIKE '$brand'
                    AND c2.name_city LIKE '$auto%'";

            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        function select_auto($db, $auto){
            $sql = "SELECT DISTINCT c2.*
                    FROM car c, city c2 
                    WHERE c.id_city = c2.id_city 
                    AND c2.name_city LIKE '$auto%'";

            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        // function select_car_type_brand($db, $car_type){

        //     $sql = "SELECT DISTINCT b.brand_name FROM cars c INNER JOIN type t INNER JOIN brand b ON c.brand = b.cod_brand AND c.type = t.cod_type WHERE t.type_name='$car_type'";
			
        //     $stmt = $db->ejecutar($sql);
        //     return $db->listar($stmt);
        // }

        // function select_auto_car_type($db, $car_type, $auto){

        //     $sql = "SELECT DISTINCT c.city FROM cars c INNER JOIN type t ON c.type = t.cod_type WHERE t.type_name='$car_type' AND c.city LIKE '$auto%'";

		// 	$stmt = $db->ejecutar($sql);
        //     return $db->listar($stmt);
        // }

        // function select_auto_car_brand($db, $car_brand, $auto){

        //     $sql = "SELECT DISTINCT c.city FROM cars c INNER JOIN brand b ON c.brand = b.cod_brand WHERE b.brand_name='$car_brand' AND c.city LIKE '$auto%'";

		// 	$stmt = $db->ejecutar($sql);
        //     return $db->listar($stmt);
        // }

        // function select_auto_car_type_brand($db, $car_type, $car_brand, $auto){

        //     $sql = "SELECT DISTINCT c.city FROM cars c INNER JOIN type t INNER JOIN brand b ON c.brand = b.cod_brand AND c.type = t.cod_type WHERE t.type_name='$car_type' AND b.brand_name='$car_brand' AND c.city LIKE '$auto%'";
			
        //     $stmt = $db->ejecutar($sql);
        //     return $db->listar($stmt);
        // }

        // function select_auto($db, $auto){

        //     $sql = "SELECT DISTINCT city FROM cars WHERE city LIKE '$auto%'";

		// 	$stmt = $db->ejecutar($sql);
        //     return $db->listar($stmt);
        // }
        
    }

?>