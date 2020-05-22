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

		if ($this->user->isAuthentifiedAdmin()):

			if (!empty($this->Data->get) && !empty($this->Data->get['target'])):

				$target = $this->Data->get['target'];

				$method = 'get' . ucfirst($target) . 'List';

				if (method_exists($this, $method)):
					$this->$method();
				else:
					echo null;
					exit;
				endif;

			endif;
		else:
			header("Location: /");
			exit;
		endif;

	}

	private function getArticlesList() {

		if (!empty($this->Data->get['orderby'])):
			$articles = $this->articlesManager->findAllOrderBy($this->Data->get['orderby'])->fetchAll();

		else:
			$articles = $this->articlesManager->findAll()->fetchAll();
		endif;

		$responseArray = array();

		foreach ($articles as $article) {
			$postArray = ["entity" => "article", "title" => $article->title(), "excerpt" => $article->contentExcerpt(60), "chapterId" => $article->chapterNumber(), 'update' => $article->updateDate(), 'type' => $article->type()];
			$responseArray[] = (object) $postArray;
		}

		echo json_encode($responseArray);

	}

	private function getCommentsList() {

	}

	private function getUsersList() {

	}

	public function addArticleAction() {

		if (!empty($this->Data->post)):

			if (!empty($this->Data->post['title']) && !empty($this->Data->post['chapternumber']) && !empty($this->Data->post['content']) && !empty($this->Data->post['type'])):

				$title = $this->Data->post['title'];
				$chapternumber = $this->Data->post['chapternumber'];
				$content = $this->Data->post['content'];
				$type = $this->Data->post['type'];

				echo $this->articlesManager->add($title, $chapternumber, $content, $type);

			else:
				echo "Des champs obligatoires ne sont pas remplis";
			endif;

		else:
			echo "une erreur est survenu";
		endif;

	}

}