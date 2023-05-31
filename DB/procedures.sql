DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `check_stock_details`(IN `param_username` VARCHAR(100), IN `param_id_car` INT, OUT `final_value` INT)
BEGIN
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
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `checkout`(IN param_username VARCHAR(100), IN param_id_car INT, IN param_cantidad INT, IN param_precio INT,
                                    	IN param_total_precio INT)
BEGIN
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
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `control_likes`(IN param_id_car INT, IN param_username VARCHAR(100))
BEGIN
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
