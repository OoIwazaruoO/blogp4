<?php

namespace Managers;

use Core\Manager;

class ArticlesManager extends Manager {

	public function __construct($dao, $table, $classname) {
		parent::__construct($dao, $table, $classname);
	}

	public function add($title, $chapterNumber, $content, $type, $pictureName = null) {

		if ($pictureName != null):
			$sql = "INSERT INTO {$this->targetTable}(title, content, type, chapterNumber, pictureName) VALUES(:title, :content, :type, :chapterNumber, :pictureName)";
			$execData = array(":title" => $title, ":content" => $content, ":type" => $type, ":chapterNumber" => $chapterNumber, ":pictureName" => $pictureName);
		else:
			$sql = "INSERT INTO {$this->targetTable}(title, content, type, chapterNumber) VALUES(:title, :content, :type, :chapterNumber)";
			$execData = array(":title" => $title, ":content" => $content, ":type" => $type, ":chapterNumber" => $chapterNumber);
		endif;

		$req = $this->dao->prepare($sql);
		$added = $req->execute($execData);

		return $added;

	}

	public function findAllOrderBy($orderby = "id") {

		$possibleOrderBy = array("id", "creationDate", "updateDate", "type", "chapterNumber");

		$index = array_search($orderby, $possibleOrderBy);

		if (!$index):
			$orderby = "id";
		endif;

		$result = $this->dao->query("SELECT * from {$this->targetTable} ORDER BY {$orderby}");

		$result->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $this->className);

		return $result;

	}

}