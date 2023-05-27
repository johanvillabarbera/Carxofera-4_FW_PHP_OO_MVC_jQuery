<?php
	$path = $_SERVER['DOCUMENT_ROOT'] . '/4_FW_PHP_OO_MVC_jQuery_v2/';
	include($path . "model/connect.php");
    
	class DAOCar{
		function insert_car($datos){
			$type="";
			$extras="";
			$license_number = $datos['license_number'];
			$brand = $datos['brand'];
			$model = $datos['model'];
   		 	$car_plate = $datos['car_plate'];
    		$km = $datos['km'];
    		$category = $datos['category'];
    		foreach ($datos['type'] as $indice) {
        	    $type=$type."$indice:";
        	}
    		$comments = $datos['comments'];
    		$discharge_date = $datos['discharge_date'];
    		$color = $datos['color'];
    		foreach ($datos['extras'] as $indice) {
        	    $extras=$extras."$indice:";
        	}
    		$car_image = $datos['car_image'];
    		$price = $datos['price'];
    		$doors = $datos['doors'];
    		$city = $datos['city'];
    		$lat = $datos['lat'];
    		$lng = $datos['lng'];
        	
        	$sql = "INSERT INTO cars(license_number, brand, model, car_plate, km, category, type, 
						comments, discharge_date, color, extras, car_image, price, doors, city, lat, lng) 
					VALUES('$license_number','$brand','$model','$car_plate','$km','$category',
						'$type','$comments','$discharge_date','$color','$extras','$car_image','$price',
						'$doors','$city','$lat','$lng')";
            $conexion = connect::con();
            $res = mysqli_query($conexion, $sql);
            connect::close($conexion);
			return $res;
		}
		
		function select_all_car(){
			$sql = "SELECT * FROM cars ORDER BY id ASC";
			
			$conexion = connect::con();
            $res = mysqli_query($conexion, $sql);
			connect::close($conexion);
            return $res;
		}
		
		function select_car($id){
			$sql = "SELECT * FROM cars WHERE id='$id'";
			
			$conexion = connect::con();
            $res = mysqli_query($conexion, $sql)->fetch_object();
            connect::close($conexion);
            return $res;
		}
		
		function update_car($datos){
			$type="";
			$extras="";
			$id = $datos['id'];
			$license_number = $datos['license_number'];
			$brand = $datos['brand'];
			$model = $datos['model'];
   		 	$car_plate = $datos['car_plate'];
    		$km = $datos['km'];
    		$category = $datos['category'];
    		foreach ($datos['type'] as $indice) {
        	    $type=$type."$indice:";
        	}
    		$comments = $datos['comments'];
    		$discharge_date = $datos['discharge_date'];
    		$color = $datos['color'];
    		foreach ($datos['extras'] as $indice) {
        	    $extras=$extras."$indice:";
        	}
    		$car_image = $datos['car_image'];
    		$price = $datos['price'];
    		$doors = $datos['doors'];
    		$city = $datos['city'];
    		$lat = $datos['lat'];
    		$lng = $datos['lng'];
        	
        	$sql = "UPDATE cars SET license_number='$license_number',brand='$brand',model='$model'
			,car_plate='$car_plate',km='$km',category='$category',type='$type',comments='$comments'
			,discharge_date='$discharge_date',color='$color',extras='$extras',car_image='$car_image'
			,price='$price',doors='$doors',city='$city',lat='$lat',lng='$lng' WHERE id='$id'";

            $conexion = connect::con();
            $res = mysqli_query($conexion, $sql);
            connect::close($conexion);
			return $res;
		}
		
		function delete_car($id){
			$sql = "DELETE FROM cars WHERE id='$id'";
			
			$conexion = connect::con();
            $res = mysqli_query($conexion, $sql);
            connect::close($conexion);
            return $res;
		}

		function delete_all_car(){
			$sql = "DELETE FROM cars";
			
			$conexion = connect::con();
            $res = mysqli_query($conexion, $sql);
            connect::close($conexion);

            return $res;
		}

		function dummies_car(){
			$sql = "DELETE FROM cars;";

			$sql.= "INSERT INTO cars (license_number, brand, model, car_plate, km, category, type, comments, discharge_date, color, extras, car_image, price, doors, city, lat, lng)" 
			." VALUES ('1W2D50JIL04J3L5K1', 'BMW', 'I4', '4567DAB', '0', 'SM', 'Híbrido:Deportivo:', 'Coche nuevo y automático', '2022-01-15', 'Grey', 'GPS:Turbo:', 'view/images/img_cars/mercedes_glc_coupe.jpg', '50000', '2', 'Madrid', '39.4697065', '-0.3763353');";
		
			$sql.= "INSERT INTO cars (license_number, brand, model, car_plate, km, category, type, comments, discharge_date, color, extras, car_image, price, doors, city, lat, lng)" 
			." VALUES ('2OUD50JIL04J3L5G6', 'CP', 'Formentor', '7645JDH', '10000', 'RT', 'Deportivo:', 'Coche nuevo y automático', '2019-07-26', 'Mate Blue', 'GPS:', 'view/images/img_cars/mercedes_glc_coupe.jpg', '32000', '3', 'Valencia', '02.4349865', '-7.3215853');";

			$sql.= "INSERT INTO cars (license_number, brand, model, car_plate, km, category, type, comments, discharge_date, color, extras, car_image, price, doors, city, lat, lng)" 
			." VALUES ('8P9D50JIL04J3L1H7', 'FRD', 'Mustang', '6547LGM', '2000', 'RT', 'Berlina:SUV:', 'Coche nuevo y automático', '2019-03-30', 'Blue', 'Turbo:Descapotable:', 'view/images/img_cars/mercedes_glc_coupe.jpg', '39000', '5', 'Barcelona', '07.4147965', '-0.3761203');";

			$sql.= "INSERT INTO cars (license_number, brand, model, car_plate, km, category, type, comments, discharge_date, color, extras, car_image, price, doors, city, lat, lng)" 
			." VALUES ('44GD50JIL04J3LH58', 'MCD', 'GLC Coupé', '9745DFM', '0', 'SM', 'SUV:', 'Coche nuevo y automático', '2019-07-26', 'Mate grey', 'Turbo:Asientos calefactables:',  'view/images/img_cars/mercedes_glc_coupe.jpg', '60000', '5', 'Barcelona', '07.4147965', '-0.3761203');";

			$sql.= "INSERT INTO cars (license_number, brand, model, car_plate, km, category, type, comments, discharge_date, color, extras, car_image, price, doors, city, lat, lng)" 
			." VALUES ('3J4750JIL04J3LKP4', 'AUD', 'A6', '2641FKL', '50000', 'SM', 'Berlina:Eléctrico:', 'Coche nuevo y automático', '2017-06-20', 'White', 'Descapotable:', 'view/images/img_cars/mercedes_glc_coupe.jpg', '28000', '4', 'Murcia', '34.4179345', '-60.1461203')";
			
			$conexion = connect::con();
            $res = mysqli_multi_query($conexion, $sql);
            connect::close($conexion);

            return $res;
		}
	}