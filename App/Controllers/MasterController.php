<?php
namespace Controllers;

use Core\MyController;
use Entities\Picture;
use Entities\User;
use Managers\ArticlesManager;
use Managers\PicturesManager;

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

		$pictureName = false;

		if (!empty($this->Data->post)):

			if (!empty($this->Data->post['title']) && !empty($this->Data->post['chapternumber']) && !empty($this->Data->post['content']) && !empty($this->Data->post['type'])):

				$title = $this->Data->post['title'];
				$chapternumber = $this->Data->post['chapternumber'];
				$content = $this->Data->post['content'];
				$type = $this->Data->post['type'];

				if (!empty($_FILES) AND !empty($_FILES['picture'])):
					$picture = new Picture($_FILES['picture']);

					if (!$picture->hasErrors()):
						$pictureName = $this->uploadPicture($picture);
					else:
						echo "une erreur est survenue avec l'image choisie";
						exit;
					endif;
				endif;

				echo $this->articlesManager->add($title, $chapternumber, $content, $type, $pictureName != false ? $pictureName : null);

			else:
				echo "Des champs obligatoires ne sont pas remplis";
			endif;

		else:
			echo "Des champs obligatoire ne sont pas remplis";
		endif;

	}

	private function uploadPicture(Picture $picture) {

		echo realpath($picture->folder());

		$this->picturesManager = new PicturesManager();

		return $this->picturesManager->uploadPicture($picture);

	}

}