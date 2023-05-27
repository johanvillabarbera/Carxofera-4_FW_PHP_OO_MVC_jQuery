<?php
    class cart_dao {
        static $_instance;

        private function __construct() {
        }

        public static function getInstance() {
            if(!(self::$_instance instanceof self)){
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        function select_product($db, $username, $id_car){
            $sql = "SELECT * 
                    FROM cart c , users u
                    WHERE c.id_user = u.id_user
                    AND u.username='$username' 
                    AND c.id_car='$id_car'";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
        }

        function insert_product($db, $username, $id_car, $cantidad){
            $sql = "INSERT INTO cart (id_user, id_car, cantidad) 
                    VALUES ((SELECT u.id_user
                            FROM users u
                            WHERE u.username = '$username'),'$id_car', '$cantidad')";
            
            return $db -> ejecutar($sql);
        }
    
        function update_product($db, $username, $id_car, $cantidad){
            $sql = "UPDATE cart 
                    SET cantidad = cantidad+'$cantidad'
                    WHERE id_user=(SELECT u.id_user
                                    FROM users u
                                    WHERE u.username = '$username')
                    AND id_car='$id_car'";
            
            return $db -> ejecutar($sql);
        }

        function select_user_cart($db, $username){
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
                    
            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
        }

        function check_stock($db, $id_car){
            $sql = "SELECT stock FROM car
                    WHERE id_car='$id_car'";
                    
            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
        }

        function check_stock_details($db, $username, $id_car){
            $sql = "CALL check_stock_details('$username','$id_car', @val);";
            
            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
        }

        
        function checkout($db, $data, $username){
            foreach($data as $fila){
                $id_car = $fila["id_car"];
                $cantidad = $fila["cantidad"];
                $precio = $fila["price"];
                $total_precio = $fila["price"]*$fila["cantidad"];

                $sql = "CALL checkout('$username','$id_car','$cantidad','$precio','$total_precio');";
                $stmt = $db -> ejecutar($sql);
            }
            return $stmt;
        }

        function delete_cart($db, $username, $id_car){
            $sql = "DELETE FROM cart 
                    WHERE id_user=(SELECT u.id_user
                                    FROM users u
                                    WHERE u.username = '$username') 
                    AND id_car='$id_car'";
            
            return $db -> ejecutar($sql);
        }

        function update_qty($db, $username, $id_car, $cantidad){
            $sql = "UPDATE cart 
                    SET cantidad = $cantidad 
                    WHERE id_user=(SELECT u.id_user
                                    FROM users u
                                    WHERE u.username = '$username')
                    AND id_car='$id_car'";
            
            return $db -> ejecutar($sql);
        }

    }
?>