CREATE TRIGGER `check_stock_au` AFTER UPDATE ON `car`
 FOR EACH ROW BEGIN
	IF OLD.stock <> NEW.stock THEN
    	DELETE FROM cart 
        WHERE id_car = NEW.id_car 
        AND cantidad > NEW.stock;
   	END IF;
END
