<?php
    function validate_license_number($license_number){
        $sql = "SELECT * FROM cars WHERE license_number='$license_number'";
        
        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql)->fetch_row();
        connect::close($conexion);
        return $res;
    }

    function validate_car_plate($car_plate){
        $sql = "SELECT * FROM cars WHERE car_plate='$car_plate'";

        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql)->fetch_row();
        connect::close($conexion);
        return $res;
    }
    
    function validate() {
        $check = true;

        $license_number = $_POST['license_number'];
        $license_number = validate_license_number($license_number);
        $car_plate = $_POST['car_plate'];
        $car_plate = validate_car_plate($car_plate);

        if($license_number !== null){
            echo '<script language="javascript">setTimeout(() => {
                toastr.error("El número de licencia no puede estar repetido");
            }, 1000);</script>';
            $check = false;
        }
        if($car_plate !== null){
            echo '<script language="javascript">setTimeout(() => {
                toastr.error("El número de placa no puede estar repetido");
            }, 1000);</script>';
            $check = false;
        }

        return $check;
    }

    function validate_update() {
        $check = true;

        $license_number = $_POST['license_number'];
        $license_number = validate_license_number($license_number);
        $car_plate = $_POST['car_plate'];
        $car_plate = validate_car_plate($car_plate);

        if($license_number !== null){
            if($license_number[1] !== $_POST['license_number_old']){
                echo '<script language="javascript">setTimeout(() => {
                    toastr.error("El número de licencia no puede estar repetido");
                }, 1000);</script>';
                $check = false;
            }
        }
        if($car_plate !== null){
            if($car_plate[4] !== $_POST['car_plate_old']){
                echo '<script language="javascript">setTimeout(() => {
                    toastr.error("El número de placa no puede estar repetido");
                }, 1000);</script>';
                $check = false;
            }
        }

        return $check;
    }
