<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/4_FW_PHP_OO_MVC_jQuery_v2/';
include($path . "module/cart/model/DAOCart.php");
include($path . "model/middleware_auth.php");
@session_start();

switch($_GET['op']){
    case 'list';
        include("module/cart/view/cart.html");
        break;
            
    case 'insert_cart';    
        try{
            $token = $_POST['token'];
            $json = decode_token($token);

            $dao = new DAOCart();
            $rdo = $dao->select_product($json['username'], $_POST['id']);
        }catch (Exception $e){
            echo json_encode("error");
            exit;
        }
        $dinfo = array();
        foreach ($rdo as $row) {
            array_push($dinfo, $row);
        }
        if(!$dinfo){
            $dao = new DAOCart();
            $rdo = $dao->insert_product($json['username'], $_POST['id'], $_POST['qty']);
            echo json_encode("insert");
            exit;
        }else{
            $dao = new DAOCart();
            $rdo = $dao->update_product($json['username'], $_POST['id'], $_POST['qty']);
            echo json_encode("update");
            exit;
        }
        break; 

    case 'delete_cart';    
        try{
            $token = $_POST['token'];
            $json = decode_token($token);
            
            $dao = new DAOCart();
            $rdo = $dao->delete_cart($json['username'], $_POST['id']);
        }catch (Exception $e){
            echo json_encode("error");
            exit;
        }
        if(!$rdo){
            echo json_encode("error");
            exit;
        }else{
            echo json_encode("delete");
            exit;
        }
        break;         

    case 'load_cart';    
        try{
            $token = $_POST['token'];
            $json = decode_token($token);
            
            $dao = new DAOCart();
            $rdo = $dao->select_user_cart($json['username']);
        }catch (Exception $e){
            echo json_encode("error");
            exit;
        }
        if(!$rdo){
            echo json_encode("error");
            exit;
        }else{
            echo json_encode($rdo);
        }
        break; 

    case 'update_qty';    
        try{
            $token = $_POST['token'];
            $json = decode_token($token);
            
            $dao = new DAOCart();
            $rdo = $dao->update_qty($json['username'], $_POST['id'],$_POST['qty']);
        }catch (Exception $e){
            echo json_encode("error");
            exit;
        }
        if(!$rdo){
            echo json_encode("error");
            exit;
        }else{
            echo json_encode("update");
            exit;
        }
        break; 
    
    case 'check_stock';    
        try{
            $dao = new DAOCart();
            $rdo = $dao->check_stock($_POST['id']);
        }catch (Exception $e){
            echo json_encode("error");
            exit;
        }
        if(!$rdo){
            echo json_encode("error");
            exit;
        }else{
            $dinfo = array();
            foreach ($rdo as $row) {
                array_push($dinfo, $row);
            }
            echo json_encode($dinfo);
        }
        break; 

    case 'check_stock_details';    
        $token = $_POST['token'];
        $json = decode_token($token);

        try{
            $dao = new DAOCart();
            $rdo = $dao->check_stock_details($json['username'], $_POST['id']);
        }catch (Exception $e){
            echo json_encode("error");
            exit;
        }
        if(!$rdo){
            echo json_encode("error");
            exit;
        }else{
            $dinfo = array();
            foreach ($rdo as $row) {
                array_push($dinfo, $row);
            }
            echo json_encode($dinfo);
        }
        break; 

    case 'checkout';    
        try{
            $token = $_POST['token'];
            $json = decode_token($token);
            
            $dao = new DAOCart();
            $rdo = $dao->select_user_cart($json['username']);
        }catch (Exception $e){
            echo json_encode("error");
            exit;
        }
        if(!$rdo){
            echo json_encode("error");
            exit;
        }else{
            $dao = new DAOCart();
            $res = $dao->checkout($rdo, $json['username']);
            echo json_encode("checkout");
            exit;
        }
        break; 
            
    default;
        include("view/inc/error404.php");
        break;
        
}
?>