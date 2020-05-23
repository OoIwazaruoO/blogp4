<?php

namespace Managers;

use Core\Manager;

class ArticlesManager extends Manager {

	public function __construct($dao, $table, $classname) {
		parent::__construct($dao, $table, $classname);
	}

	public function save($title, $chapterNumber, $content, $type, $pictureName = null, $id = null) {

		if ($id != null) {
			return $this->update($title, $chapterNumber, $content, $type, $id, $pictureName);
		} else {
			return $this->add($title, $chapterNumber, $content, $type, $pictureName);
		}

	}

	private function add($title, $chapterNumber, $content, $type, $pictureName = null) {

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

	private function update($title, $chapterNumber, $content, $type, $id, $pictureName = null) {

		if ($pictureName != null):
			$sql = "UPDATE {$this->targetTable} SET title = :title, content = :content, type = :type, chapterNumber = :chapterNumber, pictureName = :pictureName WHERE id = :id";
			$execData = array(":title" => $title, ":content" => $content, ":type" => $type, ":chapterNumber" => $chapterNumber, ":pictureName" => $pictureName, ":id" => $id);
		else:
			$sql = "UPDATE {$this->targetTable} SET title = :title, content = :content, type = :type, chapterNumber = :chapterNumber) VALUES(:title, :content, :type, :chapterNumber)";
			$execData = array(":title" => $title, ":content" => $content, ":type" => $type, ":chapterNumber" => $chapterNumber, ":id" => $id);
		endif;

		$req = $this->dao->prepare($sql);
		$updated = $req->execute($execData);

		return $updated;

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