<?php
    class shop_dao {
        static $_instance;
        
        private function __construct() {
        }
        
        public static function getInstance() {
            if(!(self::$_instance instanceof self)){
                self::$_instance = new self();
            }
            return self::$_instance;
        }
        
        public function select_all_cars($db, $total_prod, $items_page) {

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
                    LIMIT $total_prod, $items_page";

            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        function select_details($db, $id){

            $sql = "SELECT c.*, b.name_brand , m.name_model , st.name_tshift , c2.name_color, c3.name_cat , d.number_door , mt.name_tmotor, c4.name_city  
                    FROM car c, brand b , model m , shift_type st , color c2, category c3 , doors d , motor_type mt , city c4 
                    WHERE c.id_model = m.id_model 
                    AND m.id_brand = b.id_brand 
                    AND c.id_tshift = st.id_tshift 
                    AND c.id_color = c2.id_color 
                    AND c.id_cat = c3.id_cat 
                    AND c.id_door = d.id_door
                    AND c.id_tmotor = mt.id_tmotor 
                    AND c.id_city = c4.id_city 
                    AND c.id_car = '$id'";

            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        public function select_details_images($db, $id){

            $details = self::select_details($db, $id);
            $sql = "SELECT *
                    FROM img_cars i
                    WHERE i.id_car = '$id'";

            $stmt = $db->ejecutar($sql);
            
            $array = array();
            
            if (mysqli_num_rows($stmt) > 0) {
                foreach ($stmt as $row) {
                    array_push($array, $row);
                }
            }

            $rdo = array();
            $rdo[0] = $details;
            $rdo[1][] = $array;

            return $rdo;
        }

        function select_all_brands($db){
            $sql = "SELECT id_brand, name_brand
                    FROM brand";
    
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }
    
        function select_all_motor_types($db){
            $sql = "SELECT id_tmotor, name_tmotor
                    FROM motor_type";
    
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }
    
        function select_all_categories($db){
            $sql = "SELECT id_cat, name_cat
                    FROM category";
    
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }
    
        function select_all_colors($db){
            $sql = "SELECT id_color, name_color
                    FROM color";
    
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        public function select_load_filters($db) {
            $brands = self::select_all_brands($db);
            $motor_types = self::select_all_motor_types($db);
            $categories = self::select_all_categories($db);
            $colors = self::select_all_colors($db);

            $array_return = array();
            $array_return[0] = $brands;
            $array_return[1] = $motor_types;
            $array_return[2] = $categories;
            $array_return[3] = $colors;

            return $array_return;
        }

        function select_filters($db, $filter, $total_prod, $items_page){
            $sql = "SELECT cfilter.*
                    FROM (SELECT c.*, b.name_brand , b.id_brand, m.name_model , st.name_tshift , c2.name_color, ic.name_img , ca.name_cat, mt.name_tmotor, ci.name_city, ft.name_frame
                            FROM car c, brand b , model m , shift_type st , color c2 , img_cars ic , category ca, motor_type mt, city ci, frame_type ft
                            WHERE c.id_model = m.id_model 
                            AND m.id_brand = b.id_brand 
                            AND c.id_tshift = st.id_tshift 
                            AND c.id_color = c2.id_color 
                            AND ic.id_car = c.id_car 
                            AND c.id_cat = ca.id_cat
                            AND c.id_tmotor = mt.id_tmotor
                            AND c.id_city = ci.id_city
                            AND c.id_frame = ft.id_frame
                            GROUP BY c.id_car) as cfilter";
    
                for ($i=0; $i < count($filter); $i++){
                    if ($i==0){
                        $sql.= " WHERE cfilter." . $filter[$i][0] . "= '" . $filter[$i][1] . "'";
                    }else {
                        $sql.= " AND cfilter." . $filter[$i][0] . "= '" . $filter[$i][1] . "'";
                    }        
                }
    
                $sql.= "LIMIT $total_prod, $items_page";
    
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        function select_filters_sort_by($db, $filter, $total_prod, $items_page){
            $sql = "SELECT cfilter.*
                    FROM (SELECT c.*, b.name_brand , b.id_brand, m.name_model , st.name_tshift , c2.name_color, ic.name_img , ca.name_cat, mt.name_tmotor
                            FROM car c, brand b , model m , shift_type st , color c2 , img_cars ic , category ca, motor_type mt
                            WHERE c.id_model = m.id_model 
                            AND m.id_brand = b.id_brand 
                            AND c.id_tshift = st.id_tshift 
                            AND c.id_color = c2.id_color 
                            AND ic.id_car = c.id_car 
                            AND c.id_cat = ca.id_cat
                            AND c.id_tmotor = mt.id_tmotor
                            GROUP BY c.id_car) as cfilter
                            ORDER BY cfilter." . $filter[0] ." " . $filter[1] . "";
    
            $sql.= " LIMIT $total_prod, $items_page";
    
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        function select_cars_related($db, $brand, $id_car, $loaded, $items){
            $sql = "SELECT cfilter.*
                    FROM (SELECT c.*, b.name_brand , b.id_brand, m.name_model , st.name_tshift , c2.name_color, ic.name_img , ca.name_cat, mt.name_tmotor, ci.name_city, ft.name_frame
                    FROM car c, brand b , model m , shift_type st , color c2 , img_cars ic , category ca, motor_type mt, city ci, frame_type ft
                    WHERE c.id_model = m.id_model 
                    AND m.id_brand = b.id_brand 
                    AND c.id_tshift = st.id_tshift 
                    AND c.id_color = c2.id_color 
                    AND ic.id_car = c.id_car 
                    AND c.id_cat = ca.id_cat
                    AND c.id_tmotor = mt.id_tmotor
                    AND c.id_city = ci.id_city
                    AND c.id_frame = ft.id_frame
                    GROUP BY c.id_car) as cfilter
                    WHERE cfilter.name_brand LIKE '$brand'
                    AND cfilter.id_car NOT LIKE '$id_car'
                    LIMIT $loaded, $items";
    
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        function select_count_cars_related($db, $name_brand, $id_car){
            $sql = "SELECT COUNT(*) AS 'n_cars'
                    FROM car c , model m , brand b 
                    WHERE c.id_model = m.id_model AND m.id_brand = b.id_brand 
                    AND b.name_brand LIKE '$name_brand'
                    AND c.id_car NOT LIKE '$id_car'";
    
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        function select_count_cars_all($db){
            $sql = "SELECT COUNT(*) AS n_cars FROM car";

            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        function select_count_cars_filter($db, $filter){
            $sql = "SELECT COUNT(*) as 'n_cars'
                    FROM (SELECT c.*, b.name_brand , b.id_brand, m.name_model , st.name_tshift , c2.name_color, ic.name_img , ca.name_cat, mt.name_tmotor, ci.name_city, ft.name_frame
                            FROM car c, brand b , model m , shift_type st , color c2 , img_cars ic , category ca, motor_type mt, city ci, frame_type ft
                            WHERE c.id_model = m.id_model 
                            AND m.id_brand = b.id_brand 
                            AND c.id_tshift = st.id_tshift 
                            AND c.id_color = c2.id_color 
                            AND ic.id_car = c.id_car 
                            AND c.id_cat = ca.id_cat
                            AND c.id_tmotor = mt.id_tmotor
                            AND c.id_city = ci.id_city
                            AND c.id_frame = ft.id_frame
                            GROUP BY c.id_car) as cfilter";
    
                for ($i=0; $i < count($filter); $i++){
                    if ($i==0){
                        $sql.= " WHERE cfilter." . $filter[$i][0] . "= '" . $filter[$i][1] . "'";
                    }else {
                        $sql.= " AND cfilter." . $filter[$i][0] . "= '" . $filter[$i][1] . "'";
                    }        
                }
    
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        function select_control_likes($db, $id_car, $username){
            $sql = "CALL control_likes('$id_car','$username')";
            
            return $stmt = $db->ejecutar($sql);
        }

        function select_load_likes($db, $username){
            $sql = "SELECT l.id_car 
                    FROM likes l 
                    WHERE l.id_user = (SELECT u.id_user 
                                        FROM users u 
                                        WHERE u.username = '$username')";
                                        
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        public function maps_details($db, $id){

            $sql = "SELECT id, city, lat, lng FROM cars WHERE id = '$id'";

            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        public function update_view($db, $id){

            $sql = "UPDATE cars c SET visits = visits + 1 WHERE id = '$id'";

            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        public function select_count($db){

            $sql = "SELECT COUNT(*) AS num_cars FROM cars";

            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        public function select_count_filters($db, $query){

            $filters = self::sql_filter($query);

            $sql = "SELECT COUNT(*) AS num_cars FROM cars c INNER JOIN brand b INNER JOIN type t INNER JOIN category ct ON c.brand = b.cod_brand "
            . "AND c.category = ct.cod_category AND c.type = t.cod_type $filters";

            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        public function select_cars($db, $category, $type, $id, $loaded, $items){

            $sql = "SELECT c.*, b.*, t.*, ct.* FROM cars c INNER JOIN brand b INNER JOIN type t INNER JOIN category ct ON c.brand = b.cod_brand "
            . "AND c.type = t.cod_type AND c.category = ct.cod_category WHERE c.category = '$category' AND c.id <> $id OR c.type = '$type' AND c.id <> $id LIMIT $loaded, $items";

            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        public function select_likes($db, $id, $username){

            $sql = "SELECT username, id_car FROM likes WHERE username='$username' AND id_car='$id'";

            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        public function insert_likes($db, $id, $username){

            $sql = "INSERT INTO likes (username, id_car) VALUES ('$username','$id')";

            $stmt = $db->ejecutar($sql);
            return "like";
        }

        function delete_likes($db, $id, $username){

            $sql = "DELETE FROM likes WHERE username='$username' AND id_car='$id'";

            $stmt = $db->ejecutar($sql);
            return "unlike";
        }

        function filters($db, $filter, $total_prod, $items_page){
            $sql = "SELECT cfilter.*
                    FROM (SELECT c.*, b.name_brand , b.id_brand, m.name_model , st.name_tshift , c2.name_color, ic.name_img , ca.name_cat, mt.name_tmotor, ci.name_city, ft.name_frame
                            FROM car c, brand b , model m , shift_type st , color c2 , img_cars ic , category ca, motor_type mt, city ci, frame_type ft
                            WHERE c.id_model = m.id_model 
                            AND m.id_brand = b.id_brand 
                            AND c.id_tshift = st.id_tshift 
                            AND c.id_color = c2.id_color 
                            AND ic.id_car = c.id_car 
                            AND c.id_cat = ca.id_cat
                            AND c.id_tmotor = mt.id_tmotor
                            AND c.id_city = ci.id_city
                            AND c.id_frame = ft.id_frame
                            GROUP BY c.id_car) as cfilter";
    
                for ($i=0; $i < count($filter); $i++){
                    if ($i==0){
                        $sql.= " WHERE cfilter." . $filter[$i][0] . "= '" . $filter[$i][1] . "'";
                    }else {
                        $sql.= " AND cfilter." . $filter[$i][0] . "= '" . $filter[$i][1] . "'";
                    }        
                }
    
                $sql.= "LIMIT $total_prod, $items_page";
    
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }
    }

?>
