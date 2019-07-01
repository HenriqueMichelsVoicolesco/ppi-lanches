<?php 

abstract class Connection{

	private static $conn;

	public static function getConn(){

		try{
			
			if (self::$conn == null) {
				self::$conn = new PDO('mysql:host=localhost;dbname=dblanches;', 'root', '', array(PDO::MYSQL_ATTR_FOUND_ROWS => true));
			} 
			
			return self::$conn;
		} catch (PDOException $e) {
			header('Location: ?pagina=error&id='. $e->getCode());
			exit;
		}
	}
}