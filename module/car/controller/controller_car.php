<?php
    $path = $_SERVER['DOCUMENT_ROOT'] . '/4_FW_PHP_OO_MVC_jQuery_v2/';
    include($path . "module/car/model/DAOCar.php");
    
    switch($_GET['op']){
        case 'list';
            try{
                $daocar = new DAOCar();
            	$rdo = $daocar->select_all_car();
            }catch (Exception $e){
                $callback = 'index.php?page=controller_car&op=503';
			    die('<script>window.location.href="'.$callback .'";</script>');
            }
            
            if(!$rdo){
    			$callback = 'index.php?page=controller_car&op=503';
			    die('<script>window.location.href="'.$callback .'";</script>');
    		}else{
                include("module/car/view/list_car.php");
    		}
        break;
            
        case 'create';
            include("module/car/model/validate.php");
            
            $check = true;
            
            if ($_POST){
                $check=validate();

                if ($check){
                    try{
                        $daocar = new DAOCar();
    		            $rdo = $daocar->insert_car($_POST);
                    }catch (Exception $e){
                        $callback = 'index.php?page=controller_car&op=503';
        			    die('<script>window.location.href="'.$callback .'";</script>');
                    }
                    
		            if($rdo){
                        echo '<script language="javascript">setTimeout(() => {
                            toastr.success("Creado en la base de datos correctamente");
                        }, 1000);</script>';
                        $callback = 'index.php?page=controller_car&op=list';
			            die('<script>window.location.href="'.$callback .'";</script>');
            		}else{
            			$callback = 'index.php?page=controller_car&op=503';
    			        die('<script>window.location.href="'.$callback .'";</script>');
            		}
                }
            }
            include("module/car/view/create_car.php");
        break;
            
        case 'update';
            include("module/car/model/validate.php");
            
            $check = true;

            if ($_POST){
                $check = validate_update();

                if ($check){
                    try{
                        $daocar = new DAOCar();
                        $rdo = $daocar->update_car($_POST);
                    }catch (Exception $e){
                        $callback = 'index.php?page=controller_car&op=503';
                        die('<script>window.location.href="'.$callback .'";</script>');
                    }
                        
                    if($rdo){
                        echo '<script language="javascript">setTimeout(() => {
                            toastr.error("Modificado en la base de datos correctamente");
                        }, 1000);</script>';
                        $callback = 'index.php?page=controller_car&op=list';
			            die('<script>window.location.href="'.$callback .'";</script>');
                    }else{
                        $callback = 'index.php?page=controller_car&op=503';
                        die('<script>window.location.href="'.$callback .'";</script>');
                    }
                }
            }
                
            try{
                $daocar = new DAOCar();
                $rdo = $daocar->select_car($_GET['id']);
                $car=get_object_vars($rdo);
            }catch (Exception $e){
                $callback = 'index.php?page=controller_car&op=503';
                die('<script>window.location.href="'.$callback .'";</script>');
            }
                    
            if(!$rdo){
                $callback = 'index.php?page=controller_car&op=503';
                die('<script>window.location.href="'.$callback .'";</script>');
            }else{
                include("module/car/view/update_car.php");
            }

        break;
            
        case 'read';
            try{
                $daocar = new DAOCar();
            	$rdo = $daocar->select_car($_GET['id']);
            	$car=get_object_vars($rdo);
            }catch (Exception $e){
                $callback = 'index.php?page=controller_car&op=503';
			    die('<script>window.location.href="'.$callback .'";</script>');
            }
            if(!$rdo){
    			$callback = 'index.php?page=controller_car&op=503';
    			die('<script>window.location.href="'.$callback .'";</script>');
    		}else{
                include("module/car/view/read_car.php");
    		}
        break;
            
        case 'delete';
            if ($_POST){
                try{
                    $daocar = new DAOCar();
                	$rdo = $daocar->delete_car($_GET['id']);
                }catch (Exception $e){
                    $callback = 'index.php?page=controller_car&op=503';
    			    die('<script>window.location.href="'.$callback .'";</script>');
                }
            	if($rdo){
                    echo '<script language="javascript">setTimeout(() => {
                        toastr.success("Borrado en la base de datos correctamente");
                    }, 1000);</script>';
                    $callback = 'index.php?page=controller_car&op=list';
			        die('<script>window.location.href="'.$callback .'";</script>');
        		}else{
        			$callback = 'index.php?page=controller_car&op=503';
			        die('<script>window.location.href="'.$callback .'";</script>');
        		}
            }

            try{
                $daocar = new DAOCar();
                $rdo = $daocar->select_car($_GET['id']);
                $car=get_object_vars($rdo);
            }catch (Exception $e){
                $callback = 'index.php?page=controller_car&op=503';
                die('<script>window.location.href="'.$callback .'";</script>');
            }
                    
            if(!$rdo){
                $callback = 'index.php?page=controller_car&op=503';
                die('<script>window.location.href="'.$callback .'";</script>');
            }else{
                include("module/car/view/delete_car.php");
            }
        break;

        case 'delete_all';
             
            if ($_POST){
                try{
                    $daocar = new DAOCar();
                    $rdo = $daocar -> delete_all_car();
                }catch (Exception $e){
                    $callback = 'index.php?page=controller_car&op=503';
                    die('<script>window.location.href="'.$callback .'";</script>');
                }
                
                if($rdo){
                    echo '<script language="javascript">setTimeout(() => {
                        toastr.success("Lista de coches borrada correctamente");
                    }, 1000);</script>';
                    $callback = 'index.php?page=controller_car&op=list';
			        die('<script>window.location.href="'.$callback .'";</script>');
                }else{
                    $callback = 'index.php?page=controller_car&op=503';
                    die('<script>window.location.href="'.$callback .'";</script>');
                }
            }
            
            include("module/car/view/delete_all_car.php");
        break;

        case 'dummies';
            if ($_POST){
                try{
                    $daocar = new DAOCar();
                    $rdo = $daocar -> dummies_car();
                }catch (Exception $e){
                    $callback = 'index.php?page=controller_car&op=503';
                    die('<script>window.location.href="'.$callback .'";</script>');
                }
    
                if($rdo){
                    echo '<script language="javascript">setTimeout(() => {
                        toastr.success("Dummies creados correctamente");
                    }, 1000);</script>';
                    $callback = 'index.php?page=controller_car&op=list';
			        die('<script>window.location.href="'.$callback .'";</script>');
                }else{
                    $callback = 'index.php?page=controller_car&op=503';
                    die('<script>window.location.href="'.$callback .'";</script>');
                }
            }
            
            include("module/car/view/dummies_car.php");
        break;

        case 'read_modal':
            try{
                $daocar = new DAOCar();
            	$rdo = $daocar->select_car($_GET['modal']);
            }catch (Exception $e){
                echo json_encode("error");
                exit;
            }
            if(!$rdo){
    			echo json_encode("error");
                exit;
    		}else{
    		    $car=get_object_vars($rdo);
                echo json_encode($car);
                exit;
    		}
            break;
            
        default;
            include("view/inc/error404.php");
        break;
    }