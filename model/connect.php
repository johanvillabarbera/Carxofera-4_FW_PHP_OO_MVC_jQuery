<?php
	class connect{
		public static function con(){
			$credentials = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/8_CRUD_MVC v10 proves/8_MVC_CRUD/model/credentials.ini',true);
			$host = $credentials['DB']['host'];  
    		$user = $credentials['DB']['user'];                    
    		$pass = $credentials['DB']['pass'];                           
    		$db = $credentials['DB']['db'];                     
    		$port = $credentials['DB']['port'];                         
    		$tabla= $credentials['DB']['tabla'];
    		
    		$conexion = mysqli_connect($host, $user, $pass, $db, $port)or die(mysql_error());
			return $conexion;
		}
		public static function close($conexion){
			mysqli_close($conexion);
		}
	}