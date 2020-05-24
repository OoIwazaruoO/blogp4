<?php

namespace Core;

use Entities\User;
use Managers\ArticlesManager;
use Managers\CommentsManager;

abstract class MyController extends Controller {

	public function __construct($actionData) {

		parent::__construct($actionData);

		$this->startSessionIfNotStarted();

		$this->dao = DBFactory::getMysqlConnexionWithPDO();
		$this->view = new View(__DIR__ . "/../App/Views/", "template");

		$this->user = new User();

		$this->commentsManager = new CommentsManager($this->dao, "comments", 'Entities\\Comment');
		$this->articlesManager = new ArticlesManager($this->dao, "posts", "Entities\\Article");
	}

}