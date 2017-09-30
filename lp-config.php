<?php
class Config{
	protected static $_config = array();

	public static function getConfig($key){
		if(!self::$_config){
			$filename = dirname(__FILE__).DIRECTORY_SEPARATOR.'config.ini';
			$config = parse_ini_file($filename);
			if(false === $config){
				throw new Exception('File Konfigurasi Tidak Dapat dibaca');
			}
			self::$_config = $config;
		}
		if(isset(self::$_config[$key])){
			return self::$_config[$key];
		}
	}
}
?>