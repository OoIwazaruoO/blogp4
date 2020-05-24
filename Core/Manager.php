<?php

namespace Core;

abstract class Manager {

	protected $dao;
	protected $targetTable;
	protected $className;

	public function __construct($dao, $table, $className, $field = ['id']) {
		$this->dao = $dao;
		$this->targetTable = $table;
		$this->className = $className;
		$this->field = $field;
	}

	public function find($id) {

		$req = $this->dao->prepare("SELECT * from {$this->targetTable} WHERE id = ?");

		$req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $this->className);

		$req->execute(array($id));

		return $req;
	}

	public function findAll() {
		$result = $this->dao->query("SELECT * from {$this->targetTable}");

		$result->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $this->className);
		return $result;
	}

	public function findAllOrderBy($orderby = "id") {

		$index = array_search($orderby, $this->field);

		if (!$index):
			$orderby = "id";
		endif;

		$result = $this->dao->query("SELECT * from {$this->targetTable} ORDER BY {$orderby}");

		$result->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $this->className);

		return $result;

	}

	public function delete($id) {
		$deleted = $this->dao->prepare("DELETE from {$this->targetTable} WHERE id = ?");
		return $deleted->execute(array($id));
	}
}