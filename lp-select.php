<?php
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'lp-connectdb.php';
//agar file konfigurasi lp-crud dapat dilakukan maka kita buat file ini terlebih dahulu
class Select implements Iterator{
	protected $_query;
	protected $_sql;
	protected $_pointer = 0;
	protected $_numResult = 0;
	protected $_results = array();
	private $mysqli;

	function __construct($sql){
		$this->_sql = $sql;
		$this->mysqli = new Connect;
	}

	function rewind(){
		$this->_pointer = 0;
	}

	function key(){
		return $this->_pointer;
	}

	protected function _getQuery(){
		if(!$this->_query){
			$this->_query = $this->mysqli->query($this->_sql);
			if(!$this->_query){
				try{
					throw new Exception('Gagal membaca data dari database');	
				}catch(Exception $e){
					print "Error : ".$e->getMessage();
				}
			}
		}
	return $this->_query;
	}

	function _getNumResult(){
		if(!$this->_numResult){
			$hasil = $this->_getQuery();
			$this->_numResult = $hasil->num_rows;
		}
	return $this->_numResult;
	}

	function valid(){
		if(!$this->_pointer >= 0 && $this->_pointer < $this->_getNumResult()){
			return true;
		}
	return false;
	}

	protected function _getRow($pointer){
		if(isset($this->_results[$pointer])){
			return $this->_results[$pointer];
		}
		$hasil = $this->_getQuery();
		$row = $hasil->fetch_object();
		if($row){
			$this->_results[$pointer] = $row;
		}
	return $row;
	}

	function next(){
		$row = $this->_getRow($this->_pointer);
		if($row){
			$this->_pointer ++;
		}
	return $row;	
	}

	function current(){
		return $this->_getRow($this->_pointer);
	}

	function __destruct(){
		$hasil = $this->_getQuery();
		$hasil->free_result();
	}
}
?>
