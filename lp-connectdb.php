<style type="text/css">
.warning{
	border:1px solid rgba(0,0,0,.1);
	background-color: rgba(0,0,0,.05);
	width: 95%;
	margin: auto;
	height: auto;
	padding:15px 10px 15px 10px;
	border-radius: 5px;
	text-transform: capitalize;
	font-style: italic;
	color : red;
}
.success{
	border:1px solid rgba(0,0,0,.1);
	background-color: rgba(0,0,0,.05);
	width: 95%;
	margin: auto;
	height: auto;
	padding:15px 10px 15px 10px;
	border-radius: 5px;
	text-transform: capitalize;
	font-style: italic;
	color : green;
}
</style>
<?php
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'lp-config.php';
//kita menggunakan ekstensi MySqli
class Connect extends Mysqli{
	protected static $mysqli;
	private $dbhost;
	private $dbuser;
	private $dbpass;
	private $dbname;

	public function __construct(){
		$this->dbhost = config::getConfig('dbhostname');
		$this->dbuser = config::getConfig('dbusername');
		$this->dbpass = config::getConfig('dbpassword');
		$this->dbname = config::getConfig('dbname');
		@parent::__construct($this->dbhost,$this->dbuser,$this->dbpass,$this->dbname);
		if($this->connect_error){
			try{
				throw new Exception('database '.$this->dbname.' tidak ditemukan');
			}catch(Exception $e){
				print "<div class='warning'>error : ".$e->getMessage()."</div>";
			}
		}/*else if(!$this->connect_error){
			try{
				throw new Exception('database '.$this->dbname.' ditemukan');
			}catch(Exception $e){
				print "<div class='success'>Success : ".$e->getMessage()."</div>";
			}
		}*/
		return false;
	}

	public function __destruct(){
		if(self::$mysqli){
			$this->close(self::$mysqli);
		}
	}
}
/*apakah sudah konek atau belum
$koneksi = new Connect;*/
?>
