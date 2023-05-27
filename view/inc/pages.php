<?php
	if(isset($_GET['page'])){
		switch($_GET['page']){
			case "homepage";
				include("module/inicio/view/inicio.html");
				break;
			case "controller_car";
				include("module/car/controller/".$_GET['page'].".php");
				break;
			case "controller_home";
				include("module/home/controller/".$_GET['page'].".php");
				break;
			case "controller_shop";
				include("module/shop/controller/".$_GET['page'].".php");
				break;
			case "controller_login";
				include("module/login/controller/".$_GET['page'].".php");
				break;
			case "controller_cart";
				include("module/cart/controller/".$_GET['page'].".php");
				break;
			case "services";
				include("module/services/".$_GET['page'].".html");
				break;
			case "aboutus";
				include("module/aboutus/".$_GET['page'].".html");
				break;
			case "contactus";
				include("module/contact/".$_GET['page'].".html");
				break;
			case "404";
				include("view/inc/error".$_GET['page'].".php");
				break;
			case "503";
				include("view/inc/error".$_GET['page'].".php");
				break;
			default;
				include("module/inicio/view/inicio.html");
				break;
		}
	}else{
		include("module/home/controller/controller_home.php");
	}
?>