<?php

$path = $_SERVER['DOCUMENT_ROOT'] . '/4_FW_PHP_OO_MVC_jQuery_v2/';
include($path . "/model/connect.php");

class DAOCart{

    function select_product($username, $id_car){
        $sql = "SELECT * 
                FROM cart c , users u
                WHERE c.id_user = u.id_user
                AND u.username='$username' 
                AND c.id_car='$id_car'";
        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql);
        connect::close($conexion);
        return $res;
    }

    function insert_product($username, $id_car, $cantidad){
        $sql = "INSERT INTO cart (id_user, id_car, cantidad) 
                VALUES ((SELECT u.id_user
                        FROM users u
                        WHERE u.username = '$username'),'$id_car', '$cantidad')";
        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql);
        connect::close($conexion);
        return $res;
    }

    function update_product($username, $id_car, $cantidad){
        $sql = "UPDATE cart 
                SET cantidad = cantidad+'$cantidad'
                WHERE id_user=(SELECT u.id_user
                                FROM users u
                                WHERE u.username = '$username')
                AND id_car='$id_car'";
        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql);
        connect::close($conexion);
        return $res;
    }

    function select_user_cart($username){
        $sql = "SELECT c2.id_car, b.name_brand, m.name_model, c2.price, i.name_img, c.cantidad 
                FROM cart c, car c2, brand b, model m, img_cars i
                WHERE c.id_user = (SELECT u.id_user
                                    FROM users u
                                    WHERE u.username = '$username')
                AND c.id_car = c2.id_car
                AND c2.id_model = m.id_model
                AND m.id_brand = b.id_brand
                AND c2.id_car = i.id_car
                GROUP BY c2.id_car";
                
        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql);
        connect::close($conexion);

        $retrArray = array();
		if (mysqli_num_rows($res) > 0) {
			while ($row = mysqli_fetch_assoc($res)) {
				$retrArray[] = $row;
			}
		}
		return $retrArray;
    }

    function update_qty($username, $id_car, $cantidad){
        $sql = "UPDATE cart 
                SET cantidad = $cantidad 
                WHERE id_user=(SELECT u.id_user
                                FROM users u
                                WHERE u.username = '$username')
                AND id_car='$id_car'";
        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql);
        connect::close($conexion);
        return $res;
    }
    
    function delete_cart($username, $id_car){
        $sql = "DELETE FROM cart 
                WHERE id_user=(SELECT u.id_user
                                FROM users u
                                WHERE u.username = '$username') 
                AND id_car='$id_car'";
        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql);
        connect::close($conexion);
        return $res;
    }

    function check_stock($id_car){
        $sql = "SELECT stock FROM car
                WHERE id_car='$id_car'";
        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql);
        connect::close($conexion);
        return $res;
    }

    function check_stock_details($username, $id_car){
        $sql = "CALL check_stock_details('$username','$id_car', @val);";
        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql);
        connect::close($conexion);
        return $res;
    }

    function checkout($data, $username){
        // DELIMITER $$
        // CREATE OR REPLACE PROCEDURE checkout(IN param_username VARCHAR(100), IN param_id_car INT, IN param_cantidad INT, IN param_precio INT,
        //                                         IN param_total_precio INT)
        // BEGIN
        //     INSERT INTO `pedidos`(`id_user`, `id_car`, `cantidad`, `precio`, `total_precio`, `fecha`) 
        //     VALUES ((SELECT u.id_user
        //             FROM users u
        //             WHERE u.username = param_username) ,param_id_car,param_cantidad,param_precio,param_total_precio,NOW());
            
        //     UPDATE car 
        //     SET stock = stock - param_cantidad
        //     WHERE id_car = param_id_car;
            
        //     DELETE FROM cart 
        //     WHERE id_user = (SELECT u.id_user
        //                     FROM users u
        //                     WHERE u.username = param_username);
        // END$$
        // DELIMITER ;
        foreach($data as $fila){
            $id_car = $fila["id_car"];
            $cantidad = $fila["cantidad"];
            $precio = $fila["price"];
            $total_precio = $fila["price"]*$fila["cantidad"];

            $sql = "CALL checkout('$username','$id_car','$cantidad','$precio','$total_precio');";
            $conexion = connect::con();
            $res = mysqli_query($conexion, $sql);
            connect::close($conexion); 
        }
        return $res;
    }

}

?>