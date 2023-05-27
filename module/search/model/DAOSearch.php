<?php
    $path = $_SERVER['DOCUMENT_ROOT'] . '/4_FW_PHP_OO_MVC_jQuery_v2/';
    include($path . "model/connect.php");
    
	class DAOSearch {
		function select_model(){
			$sql = "SELECT DISTINCT * FROM model";

			$conexion = connect::con();
            $res = mysqli_query($conexion, $sql);
            connect::close($conexion);
            return $res;
        }

        function select_brand(){
            $sql = "SELECT DISTINCT * FROM brand";

			$conexion = connect::con();
            $res = mysqli_query($conexion, $sql);
            connect::close($conexion);
            return $res;
        }

        function select_model_brand($brand){
            $sql = "SELECT DISTINCT m.*
            FROM car c , model m , brand b 
            WHERE c.id_model = m.id_model AND b.id_brand = m.id_brand 
            and b.name_brand = '$brand'";

			$conexion = connect::con();
            $res = mysqli_query($conexion, $sql);
            connect::close($conexion);
            return $res;
        }

        function select_auto_model($auto, $model){
            $sql = "SELECT DISTINCT c2.*
                    FROM car c, city c2 , model m 
                    WHERE c.id_city = c2.id_city AND m.id_model = c.id_model 
                    AND m.name_model LIKE '$model'
                    AND c2.name_city LIKE '$auto%'";

			$conexion = connect::con();
            $res = mysqli_query($conexion, $sql);
            connect::close($conexion);
            return $res;
        }

        function select_auto_model_brand($auto, $model, $brand){
            $sql = "SELECT DISTINCT c2.*
                    FROM car c, city c2 , model m , brand b 
                    WHERE c.id_city = c2.id_city AND m.id_model = c.id_model AND b.id_brand = m.id_brand 
                    AND b.name_brand LIKE '$brand'
                    AND m.name_model LIKE '$model'
                    AND c2.name_city LIKE '$auto%'";

			$conexion = connect::con();
            $res = mysqli_query($conexion, $sql);
            connect::close($conexion);
            return $res;
        }

        function select_auto_brand($auto, $brand){
            $sql = "SELECT DISTINCT c2.*
                    FROM car c, city c2 , model m , brand b 
                    WHERE c.id_city = c2.id_city AND m.id_model = c.id_model AND b.id_brand = m.id_brand 
                    AND b.name_brand LIKE '$brand'
                    AND c2.name_city LIKE '$auto%'";

			$conexion = connect::con();
            $res = mysqli_query($conexion, $sql);
            connect::close($conexion);
            return $res;
        }

        function select_auto($auto){
            $sql = "SELECT DISTINCT c2.*
                    FROM car c, city c2 
                    WHERE c.id_city = c2.id_city 
                    AND c2.name_city LIKE '$auto%'";

			$conexion = connect::con();
            $res = mysqli_query($conexion, $sql);
            connect::close($conexion);
            return $res;
        }
	}
?>