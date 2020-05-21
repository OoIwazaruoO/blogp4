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
		$req->execute($execData);

	}

}