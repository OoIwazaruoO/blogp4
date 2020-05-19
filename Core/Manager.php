<?php

namespace Core;

abstract class Manager{

	protected $dao;
	protected $targetTable;
	protected $className;

	public function __construct($dao, $table, $className){
		$this->dao = $dao; 
		$this->targetTable = $table;
		$this->className = $className;
	}

	public function find($id){
		
		$req = $this->dao->prepare("SELECT * from {$this->targetTable} WHERE id = ?");

		$req->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, $this->className);

		$req->execute(array($id));

		return $req;
	}

	public function findAll(){
		$result = $this->dao->query("SELECT * from {$this->targetTable}");
		
		$result->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, $this->className);
		return $result;
	}

	public function delete($id){
		$this->dao->query("DELETE from {$this->targetTable} WHERE id = ?");	 
	}
}