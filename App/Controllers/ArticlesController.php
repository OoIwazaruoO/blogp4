<?php
namespace Controllers;

use Core\MyController;
use Entities\User;
use Managers\ArticlesManager;
use Managers\CommentsManager;

class ArticlesController extends MyController {

	public function __construct($actionData) {
		parent::__construct($actionData);

		$this->startSessionIfNotStarted();

		$this->articlesManager = new ArticlesManager($this->dao, "posts", 'Entities\\Article');
		$this->user = new User();
		$this->commentsManager = new CommentsManager($this->dao, "comments", 'Entities\\Comment');

	}

	public function indexAction() {
		$articles = $this->articlesManager->findAll();

		$this->view->render("blog", compact('articles'));
	}

	public function readAction() {

		if ($id = !empty($this->Data->get['id']) ? $this->Data->get['id'] : null) {
			$article = $this->articlesManager->find($id);

			$comments = $this->commentsManager->findAllFromArticle($id);

			$authentified = $this->user->isAuthentified();

			$this->view->render("read", compact('article', 'authentified', 'comments'));
			exit;
		}

		header("location: /");
	}

}