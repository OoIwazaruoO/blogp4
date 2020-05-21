<?php
namespace Controllers;

use Core\MyController;
use Entities\User;
use Managers\ArticlesManager;

class MasterController extends MyController {

	public function __construct($actionData) {
		parent::__construct($actionData);

		$this->startSessionIfNotStarted();

		$this->user = new User();
		$this->articlesManager = new ArticlesManager($this->dao, "posts", "Entities\\Article");

	}

	public function indexAction() {

		if ($this->user->isAuthentifiedAdmin()):

			$this->view->render('master', [], array('master'));

		else:

			throw new \Exception("Cette page n'existe pas");

		endif;

	}

	public function getListAction() {

		if (!empty($this->Data->post) && !empty($this->Data->post['target'])) {

			$target = $this->Data->post['target'];

			$method = 'get' . ucfirst($target) . 'List';

			if (method_exists($this, $method)):
				$this->$method();
			else:
				echo null;
				exit;
			endif;
		}

	}

	public function getArticlesList() {

	}

	public function getCommentsList() {

	}

	public function getUsersList() {

	}

	public function addArticleAction() {

		if (!empty($this->Data->post)):

			if (!empty($this->Data->post['title']) && !empty($this->Data->post['chapternumber']) && !empty($this->Data->post['content']) && !empty($this->Data->post['type'])):

				$title = $this->Data->post['title'];
				$chapternumber = $this->Data->post['chapternumber'];
				$content = $this->Data->post['content'];
				$type = $this->Data->post['type'];

				$this->articlesManager->add($title, $chapternumber, $content, $type);
			else:
				echo false;
			endif;

		else:
			echo false;
		endif;

	}

}