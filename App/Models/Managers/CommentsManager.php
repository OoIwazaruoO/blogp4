<?php

namespace Managers;

use Core\Manager;

class CommentsManager extends Manager {

	public function __construct($dao, $table, $classname) {
		parent::__construct($dao, $table, $classname, array("id", "creationDate", "author", "status"));
	}

	public function add($articleId, $author, $content) {
		$request = $this->dao->prepare("INSERT INTO {$this->targetTable} SET articleId = :articleId, author = :author, content = :content, creationDate = NOW(), status = 'OK'");

		$added = $request->execute(array(":articleId" => $articleId,
			":author" => $author,
			":content" => $content));

		return $added;

	}

	public function setAsDeleted($id) {
		$request = $this->dao->prepare("UPDATE {$this->targetTable} SET status = \"DELETED\" WHERE id = :id");
		$deleted = $request->execute(array(":id" => $id));

		return $deleted;
	}

	public function edit($content, $id) {
		$request = $this->dao->prepare("UPDATE {$this->targetTable} SET content = :content WHERE id = :id");
		$edited = $request->execute(array(":content" => $content,
			":id" => $id));

		return $edited;
	}

	public function adminEdit($content, $id) {
		$request = $this->dao->prepare("UPDATE {$this->targetTable} SET content = :content, status = \"EDITED\" WHERE id = :id");
		$edited = $request->execute(array(":content" => $content,
			":id" => $id));

		return $edited;
	}

	public function deleteFromArticle($postId) {
		$deleted = $this->dao->exec('DELETE FROM {$this->targetTable} WHERE articleId = ' . (int) $postId);
		return $deleted;
	}

	public function findAllFromArticle($articleId) {

		$id = (int) $articleId;

		$request = $this->dao->prepare("SELECT * FROM {$this->targetTable} WHERE articleId = :articleId ORDER BY creationDate DESC");

		$request->bindValue(':articleId', $articleId, \PDO::PARAM_INT);
		$request->execute();

		$request->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $this->className);

		return $request;

	}

	public function getReportedList() {
		$request = $this->dao->query("SELECT * FROM {$this->targetTable} WHERE reported");

		$request->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $this->className);

		return $request;
	}

	public function countComments($articleId = null) {

		$request = $articleId !== null ? $this->dao->prepare("SELECT COUNT(*) FROM {$this->targetTable} WHERE  articleId = :articleId")
		: $this->dao->prepare("SELECT COUNT(*) FROM {$this->targetTable}");

		$postId !== null ? $request->execute([':articleId' => $articleId]) : $request->execute();

		$commentsNumber = $request->fetch()[0];

		return $commentsNumber;
	}

}
