<?php 

abstract class Connection{

	private static $conn;

	public static function getConn(){

		if (self::$conn == null) {
			self::$conn = new PDO('mysql:host=localhost;dbname=dblanches;', 'root', '', array(PDO::MYSQL_ATTR_FOUND_ROWS => true));
		} 
		
		return self::$conn;
	}
}