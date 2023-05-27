<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/4_FW_PHP_OO_MVC_jQuery_v2/';
    include($path . "module/search/model/DAOSearch.php");

switch ($_GET['op']) {
    case 'select_model':
        try {
            $dao = new DAOSearch();
            $rdo = $dao->select_model();
        } catch (Exception $e) {
            echo json_encode("error");
            exit;
        }
        if (!$rdo) {
            echo json_encode("error");
            exit;
        } else {
            $dinfo = array();
            foreach ($rdo as $row) {
                array_push($dinfo, $row);
            }
            echo json_encode($dinfo);
        }
        break;

    case 'select_brand':
        try {
            $dao = new DAOSearch();
            $rdo = $dao->select_brand();
        } catch (Exception $e) {
            echo json_encode("error");
            exit;
        }
        if (!$rdo) {
            echo json_encode("error");
            exit;
        } else {
            $dinfo = array();
            foreach ($rdo as $row) {
                array_push($dinfo, $row);
            }
            echo json_encode($dinfo);
        }
        break;

    case 'select_model_brand':
        try {
            $dao = new DAOSearch();
            $rdo = $dao->select_model_brand($_POST['brand']);
        } catch (Exception $e) {
            echo json_encode("error");
            exit;
        }
        if (!$rdo) {
            echo json_encode("error");
            exit;
        } else {
            $dinfo = array();
            foreach ($rdo as $row) {
                array_push($dinfo, $row);
            }
            echo json_encode($dinfo);
        }
        break;

    case 'autocomplete':
        try {
            $dao = new DAOSearch();
            if (!empty($_POST['name_model']) && empty($_POST['name_brand'])) {            
                $rdo = $dao->select_auto_model($_POST['name_city'], $_POST['name_model']);
            } else if (!empty($_POST['name_model']) && !empty($_POST['name_brand'])) {
                $rdo = $dao->select_auto_model_brand($_POST['name_city'], $_POST['name_model'], $_POST['name_brand']);
            } else if (empty($_POST['name_model']) && !empty($_POST['name_brand'])) {
                $rdo = $dao->select_auto_brand($_POST['name_city'], $_POST['name_brand']);
            } else {
                $rdo = $dao->select_auto($_POST['name_city']);
            }
        } catch (Exception $e) {
            echo json_encode("error");
            exit;
        }
        if (!$rdo) {
            echo json_encode("error");
            exit;
        } else {
            $dinfo = array();
            foreach ($rdo as $row) {
                array_push($dinfo, $row);
            }
            echo json_encode($dinfo);
        }
        break;

    default:
        include("view/inc/error404.php");
        break;
}
?>