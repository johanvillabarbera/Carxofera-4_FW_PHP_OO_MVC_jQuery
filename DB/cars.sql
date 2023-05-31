-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-05-2023 a las 08:27:04
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cars`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `checkout` (IN `param_username` VARCHAR(100), IN `param_id_car` INT, IN `param_cantidad` INT, IN `param_precio` INT, IN `param_total_precio` INT)   BEGIN
	INSERT INTO `pedidos`(`id_user`, `id_car`, `cantidad`, `precio`, `total_precio`, `fecha`) 
    VALUES ((SELECT u.id_user
             FROM users u
             WHERE u.username = param_username) ,param_id_car,param_cantidad,param_precio,param_total_precio,NOW());
	
    UPDATE car 
    SET stock = stock - param_cantidad
    WHERE id_car = param_id_car;
    
    DELETE FROM cart 
    WHERE id_user = (SELECT u.id_user
                     FROM users u
                     WHERE u.username = param_username);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `check_stock_details` (IN `param_username` VARCHAR(100), IN `param_id_car` INT, OUT `final_value` INT)   BEGIN
	DECLARE stock_car INT(11);
    DECLARE qty_cart INT(11);
    
	SELECT stock 
    INTO stock_car 
    FROM car
    WHERE id_car=param_id_car;
    
    SELECT cantidad 
    INTO qty_cart 
    FROM cart
    WHERE id_user=(SELECT u.id_user
                   FROM users u
                   WHERE u.username = param_username)
    AND id_car = param_id_car;
    
    IF qty_cart IS NULL THEN
        SET qty_cart = 0;
    END IF;

    SET final_value = stock_car - qty_cart;
    SELECT final_value AS stock;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `control_likes` (IN `param_id_car` INT, IN `param_username` VARCHAR(100))   BEGIN
	IF EXISTS (SELECT l.id_car 
				FROM likes l
				WHERE l.id_user = (SELECT u.id_user 
						   			FROM users u 
						   			WHERE u.username = param_username)
				AND l.id_car = param_id_car) THEN
    BEGIN
    	DELETE FROM likes 
		WHERE id_car = param_id_car 
		AND id_user = (SELECT u.id_user 
						FROM users u 
						WHERE u.username= param_username);
    END;
    ELSE
    BEGIN
    	INSERT INTO likes (id_user, id_car, date_like) 
		VALUES ((SELECT  u.id_user 
					FROM users u 
					WHERE u.username= param_username) ,param_id_car, NOW());
    END;
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `brand`
--

CREATE TABLE `brand` (
  `id_brand` int(11) NOT NULL,
  `name_brand` varchar(25) NOT NULL,
  `img_brand` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `brand`
--

INSERT INTO `brand` (`id_brand`, `name_brand`, `img_brand`) VALUES
(1, 'Audi', 'view/img/brand/audi.png'),
(2, 'BMW', 'view/img/brand/bmw.png'),
(3, 'Chevrolet', 'view/img/brand/chevrolet.png'),
(4, 'Citroen', 'view/img/brand/citroen.png'),
(5, 'Dacia', 'view/img/brand/dacia.png'),
(6, 'Ferrari', 'view/img/brand/ferrari.png'),
(7, 'Fiat', 'view/img/brand/fiat.png'),
(8, 'Ford', 'view/img/brand/ford.png'),
(9, 'Honda', 'view/img/brand/honda.png'),
(10, 'Hyundai', 'view/img/brand/hyundai.png'),
(11, 'Infiniti', 'view/img/brand/infiniti.png'),
(12, 'Jaguar', 'view/img/brand/jaguar.png'),
(13, 'Lamborghini', 'view/img/brand/lamborghini.png'),
(14, 'Land Rover', 'view/img/brand/land_rover.png'),
(15, 'Lexus', 'view/img/brand/lexus.png'),
(16, 'Mazda', 'view/img/brand/mazda.png'),
(17, 'Mercedes', 'view/img/brand/mercedes.png'),
(18, 'Mini', 'view/img/brand/mini.png'),
(19, 'Nissan', 'view/img/brand/nissan.png'),
(20, 'Opel', 'view/img/brand/opel.png'),
(21, 'Peugeot', 'view/img/brand/peugeot.png'),
(22, 'Porsche', 'view/img/brand/porsche.png'),
(23, 'Renault', 'view/img/brand/renault.png'),
(24, 'Seat', 'view/img/brand/seat.png'),
(25, 'Suabru', 'view/img/brand/subaru.png'),
(26, 'Suzuki', 'view/img/brand/suzuki.png'),
(27, 'Tesla', 'view/img/brand/tesla.png'),
(28, 'Volkswagen', 'view/img/brand/volkswagen.png'),
(29, 'Volvo', 'view/img/brand/volvo.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `car`
--

CREATE TABLE `car` (
  `id_car` int(11) NOT NULL,
  `license_number` varchar(17) NOT NULL,
  `car_plate` varchar(8) DEFAULT NULL,
  `id_cat` int(11) DEFAULT NULL,
  `id_cc` int(11) DEFAULT NULL,
  `id_city` int(11) DEFAULT NULL,
  `id_color` int(11) DEFAULT NULL,
  `id_door` int(11) DEFAULT NULL,
  `id_label` int(11) DEFAULT NULL,
  `id_frame` int(11) DEFAULT NULL,
  `id_model` int(20) DEFAULT NULL,
  `id_tmotor` int(11) DEFAULT NULL,
  `id_seats` int(11) DEFAULT NULL,
  `id_seller` int(11) DEFAULT NULL,
  `id_tshift` int(11) DEFAULT NULL,
  `id_trunk` int(11) DEFAULT NULL,
  `id_traction` int(11) DEFAULT NULL,
  `price` int(8) DEFAULT NULL,
  `km` int(8) DEFAULT NULL,
  `lat` varchar(50) DEFAULT NULL,
  `lng` varchar(50) DEFAULT NULL,
  `discharge_date` varchar(10) DEFAULT NULL,
  `publication_date` varchar(10) DEFAULT NULL,
  `power` int(8) DEFAULT NULL,
  `count_visited` int(100) DEFAULT NULL,
  `stock` int(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `car`
--

INSERT INTO `car` (`id_car`, `license_number`, `car_plate`, `id_cat`, `id_cc`, `id_city`, `id_color`, `id_door`, `id_label`, `id_frame`, `id_model`, `id_tmotor`, `id_seats`, `id_seller`, `id_tshift`, `id_trunk`, `id_traction`, `price`, `km`, `lat`, `lng`, `discharge_date`, `publication_date`, `power`, `count_visited`, `stock`) VALUES
(1, 'ALOEGLSEO34782341', '1393ABC', 1, 4, 2, 3, 2, 3, 1, 3, 1, 3, 2, 1, 2, 3, 25000, 15000, '38.82349107018598', '-0.6025440564362557', '10/01/2015', '10/11/2022', 160, 149, 32),
(2, 'BOOEGLSEO34122342', '2393HJC', 2, 1, 3, 2, 1, 2, 2, 3, 2, 1, 1, 2, 1, 2, 56000, 70000, '38.82651469054367', '-0.601158931928131', '20/05/2005', '13/06/2017', 120, 55, 96),
(3, 'CEOEGLSEO34742343', '3393NRO', 3, 2, 1, 5, 3, 1, 3, 4, 3, 2, 1, 2, 3, 1, 90000, 5000, '38.8187256693417', '-0.6061508658021801', '23/07/2016', '07/09/2019', 340, 35, 0),
(4, 'SUSEGLSEO12782344', '4393LOL', 4, 3, 2, 6, 2, 2, 1, 6, 2, 3, 2, 3, 2, 3, 900000, 45000, '38.82557449727284', '-0.5964824224308344', '23/07/2006', '07/09/2021', 140, 16, 5),
(5, 'WEIEGLFEO37641289', '2756NRT', 5, 10, 4, 1, 4, 4, 4, 2, 4, 6, 1, 2, 3, 3, 50000, 2000, '38.83786824015811', '-0.5161870629444413', '13/09/2000', '03/10/2017', 100, 23, 25),
(6, 'QIUEFTREO90623245', '8754YPG', 1, 12, 5, 7, 5, 5, 6, 1, 2, 4, 2, 1, 2, 1, 85000, 21000, '38.76491724146362', '-0.6130905258587432', '01/04/2020', '07/08/2021', 300, 13, 15);

--
-- Disparadores `car`
--
DELIMITER $$
CREATE TRIGGER `check_stock_au` AFTER UPDATE ON `car` FOR EACH ROW BEGIN
	IF OLD.stock <> NEW.stock THEN
    	DELETE FROM cart 
        WHERE id_car = NEW.id_car 
        AND cantidad > NEW.stock;
   	END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cart`
--

CREATE TABLE `cart` (
  `id_cart` int(11) NOT NULL,
  `id_user` int(25) DEFAULT NULL,
  `id_car` int(25) DEFAULT NULL,
  `cantidad` int(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `category`
--

CREATE TABLE `category` (
  `id_cat` int(11) NOT NULL,
  `name_cat` varchar(25) NOT NULL,
  `img_cat` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `category`
--

INSERT INTO `category` (`id_cat`, `name_cat`, `img_cat`) VALUES
(1, 'KM0', 'view/img/category/km0.jpg'),
(2, 'Segunda mano', 'view/img/category/second_hand.jpg'),
(3, 'Renting', 'view/img/category/renting.jpg'),
(4, 'Nuevo', 'view/img/category/new.jpg'),
(5, 'Oferta', 'view/img/category/offer.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cc`
--

CREATE TABLE `cc` (
  `id_cc` int(11) NOT NULL,
  `number_cc` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cc`
--

INSERT INTO `cc` (`id_cc`, `number_cc`) VALUES
(1, '1000'),
(2, '1200'),
(3, '1400'),
(4, '1600'),
(5, '1800'),
(6, '2000'),
(7, '2200'),
(8, '2400'),
(9, '2600'),
(10, '2800'),
(11, '3000'),
(12, '3500'),
(13, '4000'),
(14, '4500'),
(15, '5000'),
(16, '5500'),
(17, '6000'),
(18, '6500'),
(19, '7000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `city`
--

CREATE TABLE `city` (
  `id_city` int(11) NOT NULL,
  `id_province` int(11) DEFAULT NULL,
  `name_city` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `city`
--

INSERT INTO `city` (`id_city`, `id_province`, `name_city`) VALUES
(1, 46, 'Ontinyent'),
(2, 46, 'Xàtiva'),
(3, 46, 'Agullent'),
(4, 46, 'Albaida'),
(5, 46, 'Bocairent'),
(6, 2, 'Almansa'),
(7, 44, 'Villarluengo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coche_tiene_extra`
--

CREATE TABLE `coche_tiene_extra` (
  `id_car` int(11) NOT NULL,
  `id_extra` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `coche_tiene_extra`
--

INSERT INTO `coche_tiene_extra` (`id_car`, `id_extra`) VALUES
(1, 2),
(1, 4),
(2, 1),
(2, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `color`
--

CREATE TABLE `color` (
  `id_color` int(11) NOT NULL,
  `name_color` varchar(25) NOT NULL,
  `img_color` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `color`
--

INSERT INTO `color` (`id_color`, `name_color`, `img_color`) VALUES
(1, 'Blanco', 'view/img/color/white.jpg'),
(2, 'Gris', 'view/img/color/grey.jpg'),
(3, 'Negro', 'view/img/color/black.jpg'),
(4, 'Plata', 'view/img/color/silver.jpg'),
(5, 'Azul', 'view/img/color/blue.jpg'),
(6, 'Rojo', 'view/img/color/red.jpg'),
(7, 'Marron', 'view/img/color/brown.jpg'),
(8, 'Verde', 'view/img/color/green.jpg'),
(9, 'Amarillo', 'view/img/color/yellow.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doors`
--

CREATE TABLE `doors` (
  `id_door` int(11) NOT NULL,
  `number_door` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `doors`
--

INSERT INTO `doors` (`id_door`, `number_door`) VALUES
(1, '2'),
(2, '3'),
(3, '4'),
(4, '5'),
(5, '6'),
(6, '7');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `env_label`
--

CREATE TABLE `env_label` (
  `id_label` int(11) NOT NULL,
  `name_label` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `env_label`
--

INSERT INTO `env_label` (`id_label`, `name_label`) VALUES
(1, 'A'),
(2, 'B'),
(3, 'C'),
(4, 'Ambiental Eco'),
(5, 'Ambiental 0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `extras`
--

CREATE TABLE `extras` (
  `id_extra` int(11) NOT NULL,
  `name_extra` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `extras`
--

INSERT INTO `extras` (`id_extra`, `name_extra`) VALUES
(1, 'Cámara de visión 360 grados'),
(2, 'Conexión a Internet'),
(3, 'Sistema de entretenimiento en los asientos posteriores'),
(4, 'Frenada automática de emergencia'),
(5, 'Acceso y arranque sin llave'),
(6, 'Ayuda al arranque en pendientes'),
(7, 'Conectividad con cargador inalámbrico'),
(8, 'Control de crucero adaptativo'),
(9, 'Detección del ángulo muerto'),
(10, 'Faros LED con cambio automático de luces'),
(11, 'Navegador con tráfico en tiempo real');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `frame_type`
--

CREATE TABLE `frame_type` (
  `id_frame` int(11) NOT NULL,
  `name_frame` varchar(25) DEFAULT NULL,
  `img_frame` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `frame_type`
--

INSERT INTO `frame_type` (`id_frame`, `name_frame`, `img_frame`) VALUES
(1, 'Berlina', 'view/img/frame_type/berlina.jpg'),
(2, 'Familiar', 'view/img/frame_type/familiar.jpg'),
(3, 'Coupe', 'view/img/frame_type/coupe.jpg'),
(4, 'Monovolumen', 'view/img/frame_type/monovolumen.jpg'),
(5, 'SUV', 'view/img/frame_type/SUV.jpg'),
(6, 'Cabrio', 'view/img/frame_type/cabrio.jpg'),
(7, 'Pick Up', 'view/img/frame_type/pickup.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `img_cars`
--

CREATE TABLE `img_cars` (
  `id_img` int(11) NOT NULL,
  `name_img` varchar(200) DEFAULT NULL,
  `id_car` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `img_cars`
--

INSERT INTO `img_cars` (`id_img`, `name_img`, `id_car`) VALUES
(1, 'view/img/img_cars/audiA6_1.jpg', 1),
(2, 'view/img/img_cars/audiA6_2.jpg', 1),
(3, 'view/img/img_cars/audiA6_3.jpg', 1),
(4, 'view/img/img_cars/audiA6_4.jpg', 2),
(5, 'view/img/img_cars/audiA6_5.jpg', 2),
(6, 'view/img/img_cars/audiA6_6.jpg', 2),
(7, 'view/img/img_cars/audiA6_7.jpg', 2),
(8, 'view/img/img_cars/bmwX6_1.jpg', 3),
(9, 'view/img/img_cars/bmwX6_2.jpg', 3),
(10, 'view/img/img_cars/bmwX6_3.jpg', 3),
(11, 'view/img/img_cars/bmwX6_4.jpg', 3),
(12, 'view/img/img_cars/bmwM5_1.jpg', 4),
(13, 'view/img/img_cars/bmwM5_2.jpg', 4),
(14, 'view/img/img_cars/bmwM5_3.jpg', 4),
(15, 'view/img/img_cars/audiA4_1.jpg', 5),
(16, 'view/img/img_cars/audiA4_2.jpg', 5),
(17, 'view/img/img_cars/audiA4_3.jpg', 5),
(18, 'view/img/img_cars/audiA3_1.jpg', 6),
(19, 'view/img/img_cars/audiA3_2.jpg', 6),
(20, 'view/img/img_cars/audiA3_3.jpg', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `likes`
--

CREATE TABLE `likes` (
  `id_like` int(11) NOT NULL,
  `id_user` int(30) NOT NULL,
  `id_car` int(11) DEFAULT NULL,
  `date_like` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `likes`
--

INSERT INTO `likes` (`id_like`, `id_user`, `id_car`, `date_like`) VALUES
(87, 44, 1, '2023-04-04'),
(88, 45, 3, '2023-04-04'),
(122, 40, 5, '2023-04-07'),
(138, 40, 3, '2023-05-19'),
(139, 55, 1, '2023-05-30'),
(150, 40, 2, '2023-05-31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model`
--

CREATE TABLE `model` (
  `id_model` int(20) NOT NULL,
  `name_model` varchar(25) DEFAULT NULL,
  `id_brand` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `model`
--

INSERT INTO `model` (`id_model`, `name_model`, `id_brand`) VALUES
(1, 'A3', 1),
(2, 'A4', 1),
(3, 'A6', 1),
(4, 'X6', 2),
(5, 'X7', 2),
(6, 'M5', 2),
(7, 'Camaro', 3),
(8, 'Corvette', 3),
(9, 'Cavalier', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `motor_type`
--

CREATE TABLE `motor_type` (
  `id_tmotor` int(11) NOT NULL,
  `name_tmotor` varchar(25) DEFAULT NULL,
  `img_tmotor` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `motor_type`
--

INSERT INTO `motor_type` (`id_tmotor`, `name_tmotor`, `img_tmotor`) VALUES
(1, 'Gasolina', 'view/img/motor_type/gasolina.jpg'),
(2, 'Diesel', 'view/img/motor_type/diesel.jpg'),
(3, 'Hibrido', 'view/img/motor_type/hibrido.jpg'),
(4, 'Electrico', 'view/img/motor_type/electrico.jpg'),
(5, 'Hibrido enchufable', 'view/img/motor_type/hibrido_enchufable.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id_ped` int(11) NOT NULL,
  `id_user` int(18) DEFAULT NULL,
  `id_car` int(18) DEFAULT NULL,
  `cantidad` int(25) DEFAULT NULL,
  `precio` int(18) DEFAULT NULL,
  `total_precio` int(18) DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id_ped`, `id_user`, `id_car`, `cantidad`, `precio`, `total_precio`, `fecha`) VALUES
(1, 40, 1, 1, 0, 0, '2023-04-24'),
(2, 40, 1, 1, 25000, 25000, '2023-04-24'),
(3, 40, 1, 1, 25000, 25000, '2023-04-24'),
(4, 40, 1, 1, 25000, 25000, '2023-04-24'),
(5, 40, 2, 1, 56000, 56000, '2023-04-24'),
(6, 40, 1, 1, 25000, 25000, '2023-04-24'),
(7, 40, 1, 1, 25000, 25000, '2023-04-24'),
(8, 40, 1, 1, 25000, 25000, '2023-04-24'),
(9, 40, 1, 4, 25000, 100000, '2023-04-27'),
(10, 40, 3, 6, 90000, 540000, '2023-04-27'),
(11, 40, 3, 4, 90000, 360000, '2023-04-27'),
(12, 40, 1, 4, 25000, 100000, '2023-05-21'),
(13, 40, 2, 3, 56000, 168000, '2023-05-21'),
(14, 40, 1, 3, 25000, 75000, '2023-05-21'),
(15, 40, 1, 2, 25000, 50000, '2023-05-29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `province`
--

CREATE TABLE `province` (
  `id_province` int(11) NOT NULL,
  `name_province` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `province`
--

INSERT INTO `province` (`id_province`, `name_province`) VALUES
(1, 'Álava'),
(2, 'Albacete'),
(3, 'Alicante'),
(4, 'Almería'),
(5, 'Ávila'),
(6, 'Badajoz'),
(7, 'Baleares'),
(8, 'Barcelona'),
(9, 'Burgos'),
(10, 'Cáceres'),
(11, 'Cádiz'),
(12, 'Castellón'),
(13, 'Ciudad Real'),
(14, 'Córdoba'),
(15, 'A Coruña'),
(16, 'Cuenca'),
(17, 'Girona'),
(18, 'Granada'),
(19, 'Guadalajara'),
(20, 'Gipuzkoa'),
(21, 'Huelva'),
(22, 'Huesca'),
(23, 'Jaén'),
(24, 'León'),
(25, 'Lleida'),
(26, 'La Rioja'),
(27, 'Lugo'),
(28, 'Madrid'),
(29, 'Málaga'),
(30, 'Murcia'),
(31, 'Navarra'),
(32, 'Ourense'),
(33, 'Asturias'),
(34, 'Palencia'),
(35, 'Las Palmas'),
(36, 'Pontevedra'),
(37, 'Salamanca'),
(38, 'Santa Cruz de Tenerife'),
(39, 'Cantabria'),
(40, 'Segovia'),
(41, 'Sevilla'),
(42, 'Soria'),
(43, 'Tarragona'),
(44, 'Teruel'),
(45, 'Toledo'),
(46, 'Valencia'),
(47, 'Valladolid'),
(48, 'Bizkaia'),
(49, 'Zamora'),
(50, 'Zaragoza'),
(51, 'Ceuta'),
(52, 'Melilla');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seats_number`
--

CREATE TABLE `seats_number` (
  `id_seats` int(11) NOT NULL,
  `name_seats` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `seats_number`
--

INSERT INTO `seats_number` (`id_seats`, `name_seats`) VALUES
(1, '2'),
(2, '3'),
(3, '4'),
(4, '5'),
(5, '6'),
(6, '7'),
(7, '8'),
(8, '9');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seller_type`
--

CREATE TABLE `seller_type` (
  `id_seller` int(11) NOT NULL,
  `name_seller` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `seller_type`
--

INSERT INTO `seller_type` (`id_seller`, `name_seller`) VALUES
(1, 'Particular'),
(2, 'Profesional');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `shift_type`
--

CREATE TABLE `shift_type` (
  `id_tshift` int(11) NOT NULL,
  `name_tshift` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `shift_type`
--

INSERT INTO `shift_type` (`id_tshift`, `name_tshift`) VALUES
(1, 'Automático'),
(2, 'Manual'),
(3, 'Semi-Automático');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trunk_capacity`
--

CREATE TABLE `trunk_capacity` (
  `id_trunk` int(11) NOT NULL,
  `name_trunk` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `trunk_capacity`
--

INSERT INTO `trunk_capacity` (`id_trunk`, `name_trunk`) VALUES
(1, 'Pequeño'),
(2, 'Mediano'),
(3, 'Grande');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id_user` int(30) NOT NULL,
  `username` varchar(25) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `type_user` varchar(50) DEFAULT NULL,
  `avatar` varchar(100) DEFAULT NULL,
  `activate` int(1) NOT NULL,
  `token_email` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `email`, `type_user`, `avatar`, `activate`, `token_email`) VALUES
(40, 'Paliri', '$2y$12$lVdCWpPczpkSwzG0x/MZzuXvgfR2Fd20InFL1aG8W9Cml2NfX4keK', 'paliri@gmail.com', 'client', 'https://i.pravatar.cc/500?u=c1bf042ee0fda6136462134d7a45362b', 1, ''),
(44, 'Paliri2', '$2y$12$cRAFJaWmyRdmqhjkE3hmRu8XG6mn3LSPczlbj92r7L4V5GLxqzzW2', 'paliri2@gmail.com', 'client', 'https://i.pravatar.cc/500?u=36f2d437f5c87fd8be39b6c098cc1d0f', 0, ''),
(45, 'Paliri3', '$2y$12$RKDAS./HadxzbOihtyq90OyFtFSPmG5Eni8wn2MVa6pvq8iyaYBQ2', 'paliri3@gmail.com', 'client', 'https://i.pravatar.cc/500?u=6a5712b5c2d3ed63889d92dd5262d8b9', 0, ''),
(46, 'Paliri4', '$2y$12$itvFEM5VgUVjfTZxRnGZQu1o07rVvTRKemXhMotelE/agNQ4h9/ve', 'paliri4@gmail.com', 'client', 'https://i.pravatar.cc/500?u=9999fb72737b448edc8c86bb827fb2fb', 0, ''),
(47, 'Paliri5', '', 'paliri5@gmail.com', 'client', 'https://i.pravatar.cc/500?u=791f3e116bdae73aaa2c2c587441850a', 0, ''),
(48, 'Paliri6', '$2y$12$InnWBgMg1wKD5BOSJhw.2.73fB1k7ivKWd/.3hyvJCPQZf26Bi5fi', 'paliri6@gmail.com', 'client', 'https://i.pravatar.cc/500?u=58178f734106c754e45ac5e6afe29381', 0, ''),
(49, 'Paliri7', '$2y$12$Xsps0ZRj76cqUHBTJpq1mOxI6GOc4owbfWtthUEbbN4NA51fWytmu', 'paliri7@gmail.com', 'client', 'https://i.pravatar.cc/500?u=2f0012755de8c7a944beec71b90b2742', 0, 'ab567f7597e14148cfe9'),
(50, 'Paliri8', '$2y$12$0X5XELEwNMimduqo9lKRsujRhl780A2y5oVsbJMmxU5UtPe.38tYK', 'paliri8@gmail.com', 'client', 'https://i.pravatar.cc/500?u=d91f66740269ea7b79025d73d7c51677', 0, 'a2e6c264f1e7ba4c8f2f'),
(51, 'Paliri9', '$2y$12$S.xGYwTwpVvUUSziucZ0M.dz.ki7.JAS3DtIO5RxV5gxFPNQZjPr2', 'paliri9@gmail.com', 'client', 'https://i.pravatar.cc/500?u=0c3684c567fad66a4da5168ad1118524', 0, '9b7289b81fc6afce733d'),
(52, 'Paliri10', '$2y$12$bp3mZzvv1MU9hZAUZqj4ou90OyB2b6K8bV4SaYxoeN9XHa8lJSLaC', 'paliri10@gmail.com', 'client', 'https://i.pravatar.cc/500?u=7ebd1d94dec5e59ee2900beb5eb9f9b6', 1, ''),
(53, 'Paliri11', '$2y$12$VDyOvGQ1YVKUfbQuMqEdyeiZzsQCdK0lNThi37z3NG88dOINwloze', 'paliri11@gmail.com', 'client', 'https://i.pravatar.cc/500?u=6f85b99c1d4d14d0e2febf34931652e8', 1, ''),
(54, 'Paliri12', '$2y$12$8OmVD2oNWAJ0DvFHnOGcTuiH58o/Ez6p3LYowUorgdJAwi.nxHCI2', 'paliri12@gmail.com', 'client', 'https://i.pravatar.cc/500?u=f4c6b240b182c2e539a489795419b875', 1, ''),
(55, 'johanvillabarbera', '', 'johanvillabarbera@gmail.com', 'client', 'https://lh3.googleusercontent.com/a/AAcHTtfNGiJ1eKqvXO4ZVhxx_mkOhTqMVQgUniHZmRdhBGs=s96-c', 1, ''),
(56, 'axuelputoamo', '', 'axuelputoamo@gmail.com', 'client', 'https://lh3.googleusercontent.com/a/AAcHTtckulIk8ESak7E-WMWV9wcG5826shf7WRJ2j12X=s96-c', 1, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wheel_traction`
--

CREATE TABLE `wheel_traction` (
  `id_traction` int(11) NOT NULL,
  `name_traction` varchar(25) DEFAULT NULL,
  `img_traction` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `wheel_traction`
--

INSERT INTO `wheel_traction` (`id_traction`, `name_traction`, `img_traction`) VALUES
(1, 'Delantera', 'view/img/wheel_traction/delantera.jpg'),
(2, 'Trasera', 'view/img/wheel_traction/trasera.jpg'),
(3, 'Integral', 'view/img/wheel_traction/integral.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id_brand`);

--
-- Indices de la tabla `car`
--
ALTER TABLE `car`
  ADD PRIMARY KEY (`id_car`),
  ADD UNIQUE KEY `license_number` (`license_number`),
  ADD KEY `car_fk_1` (`id_cat`),
  ADD KEY `car_fk_2` (`id_cc`),
  ADD KEY `car_fk_3` (`id_city`),
  ADD KEY `car_fk_4` (`id_color`),
  ADD KEY `car_fk_5` (`id_door`),
  ADD KEY `car_fk_6` (`id_label`),
  ADD KEY `car_fk_7` (`id_frame`),
  ADD KEY `car_fk_8` (`id_model`),
  ADD KEY `car_fk_9` (`id_tmotor`),
  ADD KEY `car_fk_10` (`id_seats`),
  ADD KEY `car_fk_11` (`id_seller`),
  ADD KEY `car_fk_12` (`id_tshift`),
  ADD KEY `car_fk_13` (`id_trunk`),
  ADD KEY `car_fk_14` (`id_traction`);

--
-- Indices de la tabla `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id_cart`);

--
-- Indices de la tabla `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id_cat`);

--
-- Indices de la tabla `cc`
--
ALTER TABLE `cc`
  ADD PRIMARY KEY (`id_cc`);

--
-- Indices de la tabla `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id_city`),
  ADD KEY `city_fk_1` (`id_province`);

--
-- Indices de la tabla `coche_tiene_extra`
--
ALTER TABLE `coche_tiene_extra`
  ADD PRIMARY KEY (`id_car`,`id_extra`),
  ADD KEY `coche_tiene_extra_fk2` (`id_extra`);

--
-- Indices de la tabla `color`
--
ALTER TABLE `color`
  ADD PRIMARY KEY (`id_color`);

--
-- Indices de la tabla `doors`
--
ALTER TABLE `doors`
  ADD PRIMARY KEY (`id_door`);

--
-- Indices de la tabla `env_label`
--
ALTER TABLE `env_label`
  ADD PRIMARY KEY (`id_label`);

--
-- Indices de la tabla `extras`
--
ALTER TABLE `extras`
  ADD PRIMARY KEY (`id_extra`);

--
-- Indices de la tabla `frame_type`
--
ALTER TABLE `frame_type`
  ADD PRIMARY KEY (`id_frame`);

--
-- Indices de la tabla `img_cars`
--
ALTER TABLE `img_cars`
  ADD PRIMARY KEY (`id_img`),
  ADD KEY `img_cars_fk_1` (`id_car`);

--
-- Indices de la tabla `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id_like`),
  ADD KEY `id_car` (`id_car`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `date_like` (`date_like`);

--
-- Indices de la tabla `model`
--
ALTER TABLE `model`
  ADD PRIMARY KEY (`id_model`),
  ADD KEY `model_fk1` (`id_brand`);

--
-- Indices de la tabla `motor_type`
--
ALTER TABLE `motor_type`
  ADD PRIMARY KEY (`id_tmotor`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_ped`),
  ADD KEY `ped_ibfk_1` (`id_user`),
  ADD KEY `ped_ibfk_2` (`id_car`);

--
-- Indices de la tabla `province`
--
ALTER TABLE `province`
  ADD PRIMARY KEY (`id_province`);

--
-- Indices de la tabla `seats_number`
--
ALTER TABLE `seats_number`
  ADD PRIMARY KEY (`id_seats`);

--
-- Indices de la tabla `seller_type`
--
ALTER TABLE `seller_type`
  ADD PRIMARY KEY (`id_seller`);

--
-- Indices de la tabla `shift_type`
--
ALTER TABLE `shift_type`
  ADD PRIMARY KEY (`id_tshift`);

--
-- Indices de la tabla `trunk_capacity`
--
ALTER TABLE `trunk_capacity`
  ADD PRIMARY KEY (`id_trunk`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `wheel_traction`
--
ALTER TABLE `wheel_traction`
  ADD PRIMARY KEY (`id_traction`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `brand`
--
ALTER TABLE `brand`
  MODIFY `id_brand` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `car`
--
ALTER TABLE `car`
  MODIFY `id_car` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `cart`
--
ALTER TABLE `cart`
  MODIFY `id_cart` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `category`
--
ALTER TABLE `category`
  MODIFY `id_cat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `cc`
--
ALTER TABLE `cc`
  MODIFY `id_cc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `city`
--
ALTER TABLE `city`
  MODIFY `id_city` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `color`
--
ALTER TABLE `color`
  MODIFY `id_color` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `doors`
--
ALTER TABLE `doors`
  MODIFY `id_door` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `env_label`
--
ALTER TABLE `env_label`
  MODIFY `id_label` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `extras`
--
ALTER TABLE `extras`
  MODIFY `id_extra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `frame_type`
--
ALTER TABLE `frame_type`
  MODIFY `id_frame` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `img_cars`
--
ALTER TABLE `img_cars`
  MODIFY `id_img` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `likes`
--
ALTER TABLE `likes`
  MODIFY `id_like` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT de la tabla `model`
--
ALTER TABLE `model`
  MODIFY `id_model` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `motor_type`
--
ALTER TABLE `motor_type`
  MODIFY `id_tmotor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_ped` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `province`
--
ALTER TABLE `province`
  MODIFY `id_province` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de la tabla `seats_number`
--
ALTER TABLE `seats_number`
  MODIFY `id_seats` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `seller_type`
--
ALTER TABLE `seller_type`
  MODIFY `id_seller` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `shift_type`
--
ALTER TABLE `shift_type`
  MODIFY `id_tshift` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `trunk_capacity`
--
ALTER TABLE `trunk_capacity`
  MODIFY `id_trunk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de la tabla `wheel_traction`
--
ALTER TABLE `wheel_traction`
  MODIFY `id_traction` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `car`
--
ALTER TABLE `car`
  ADD CONSTRAINT `car_fk_1` FOREIGN KEY (`id_cat`) REFERENCES `category` (`id_cat`),
  ADD CONSTRAINT `car_fk_10` FOREIGN KEY (`id_seats`) REFERENCES `seats_number` (`id_seats`),
  ADD CONSTRAINT `car_fk_11` FOREIGN KEY (`id_seller`) REFERENCES `seller_type` (`id_seller`),
  ADD CONSTRAINT `car_fk_12` FOREIGN KEY (`id_tshift`) REFERENCES `shift_type` (`id_tshift`),
  ADD CONSTRAINT `car_fk_13` FOREIGN KEY (`id_trunk`) REFERENCES `trunk_capacity` (`id_trunk`),
  ADD CONSTRAINT `car_fk_14` FOREIGN KEY (`id_traction`) REFERENCES `wheel_traction` (`id_traction`),
  ADD CONSTRAINT `car_fk_2` FOREIGN KEY (`id_cc`) REFERENCES `cc` (`id_cc`),
  ADD CONSTRAINT `car_fk_3` FOREIGN KEY (`id_city`) REFERENCES `city` (`id_city`),
  ADD CONSTRAINT `car_fk_4` FOREIGN KEY (`id_color`) REFERENCES `color` (`id_color`),
  ADD CONSTRAINT `car_fk_5` FOREIGN KEY (`id_door`) REFERENCES `doors` (`id_door`),
  ADD CONSTRAINT `car_fk_6` FOREIGN KEY (`id_label`) REFERENCES `env_label` (`id_label`),
  ADD CONSTRAINT `car_fk_7` FOREIGN KEY (`id_frame`) REFERENCES `frame_type` (`id_frame`),
  ADD CONSTRAINT `car_fk_8` FOREIGN KEY (`id_model`) REFERENCES `model` (`id_model`),
  ADD CONSTRAINT `car_fk_9` FOREIGN KEY (`id_tmotor`) REFERENCES `motor_type` (`id_tmotor`);

--
-- Filtros para la tabla `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`id_car`) REFERENCES `car` (`id_car`);

--
-- Filtros para la tabla `city`
--
ALTER TABLE `city`
  ADD CONSTRAINT `city_fk_1` FOREIGN KEY (`id_province`) REFERENCES `province` (`id_province`);

--
-- Filtros para la tabla `coche_tiene_extra`
--
ALTER TABLE `coche_tiene_extra`
  ADD CONSTRAINT `coche_tiene_extra_fk2` FOREIGN KEY (`id_extra`) REFERENCES `extras` (`id_extra`),
  ADD CONSTRAINT `coche_tiene_extra_fk_1` FOREIGN KEY (`id_car`) REFERENCES `car` (`id_car`);

--
-- Filtros para la tabla `img_cars`
--
ALTER TABLE `img_cars`
  ADD CONSTRAINT `img_cars_fk_1` FOREIGN KEY (`id_car`) REFERENCES `car` (`id_car`);

--
-- Filtros para la tabla `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`id_car`) REFERENCES `car` (`id_car`),
  ADD CONSTRAINT `likes_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Filtros para la tabla `model`
--
ALTER TABLE `model`
  ADD CONSTRAINT `model_fk1` FOREIGN KEY (`id_brand`) REFERENCES `brand` (`id_brand`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `ped_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `ped_ibfk_2` FOREIGN KEY (`id_car`) REFERENCES `car` (`id_car`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
