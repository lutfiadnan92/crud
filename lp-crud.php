<?php
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'lp-connectdb.php';
class Crud{
	protected $_tableName;
	private $mysqli;

	public function __construct($tableName){
		$this->_tableName = $tableName;
		$this->mysqli = new Connect;
	}

	function simpan(array $data){
		$sql = "INSERT INTO ".$this->_tableName." SET";
		foreach($data as $field => $value){
			$sql .= " ".$field."='".$this->mysqli->real_escape_string($value)."',";
		}
		$sql = trim($sql, ',');
		$result = $this->mysqli->query($sql);
		if(!$result){
			try{
				throw new Exception('Gagal menyimpan ke table '.$this->_tableName.'');	
			}catch(Exception $e){
				print "Error : ".$e->getMessage();
			}
		}
	}

	function edit(array $data, $where = ''){
		$sql = "UPDATE ".$this->_tableName." SET";
		foreach($data as $field => $value){
			$sql .= " ".$field."='".$this->mysqli->real_escape_string($value)."',";
		}
		$sql = trim($sql, ',');
		if($where){
			$sql .= " WHERE ".$where;
		}
		$result = $this->mysqli->query($sql);
		if(!$result){
			try{
				throw new Exception('Gagal mengupdate pada table '.$this->_tableName.'');	
			}catch(Exception $e){
				print "Error : ".$e->getMessage();
			}
		}
	}

	function hapus($where = ''){
		$sql = "DELETE FROM ".$this->_tableName."";
		if($where){
			$sql .= " WHERE ".$where;
		}
		$result = $this->mysqli->query($sql);
		if(!$result){
			try{
				throw new Exception('Gagal delete data dari table '.$this->_tableName.'');	
			}catch(Exception $e){
				print "Error : ".$e->getMessage();
			}
		}
	}

	function temukansemua($orderBy = '', $orderType = 'desc', $limit = ''){
		include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'lp-select.php';
		$sql = "SELECT * FROM ".$this->_tableName."";
		if(!empty($orderBy)){
			$sql .= " ORDER BY ".$orderBy." ".$orderType;
		}
		if(!empty($limit)){
			$sql .= " LIMIT ".$limit;
		}
		return new Select($sql);
	}

	function temukandengan($field,$value){
		include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'lp-select.php';
		$sql = "SELECT * FROM ".$this->_tableName."";
		$sql .=" WHERE ".$field."='".$this->mysqli->real_escape_string($value)."'";
		return new Select($sql);
	}
}/*
$crud = new Crud('register');
$data=array(
    'id'=>'null',
    'nama'=>'Amry Rosyadi',
    'ttl'=>'Palu, Januari 1990',
    'alamat'=>'Jl. Towua II',
    'email'=>'amry@gmail.com',
    'user'=>'amry',
    'pass'=>'123'
);
$crud->simpan($data);
*/
?>