<?php
namespace Controllers;

use Core\MyController;
use Entities\Picture;
use Managers\PicturesManager;

class ArticlesController extends MyController {

	public function __construct($actionData) {

		parent::__construct($actionData);

	}

	public function indexAction() {
		$articles = $this->articlesManager->findAll();

		$this->view->render("blog", compact('articles'));
	}

	public function readAction() {

		if ($id = $this->Data->get['id'] ?? null) {

			$article = $this->articlesManager->find($id);
			$comments = $this->commentsManager->findAllFromArticle($id);

			$authentified = $this->user->isAuthentified();

			$this->view->render("read", compact('article', 'comments', 'authentified'));
			exit;
		}

		header("location: /");
	}

	public function getListAction() {

		if ($this->user->isAuthentifiedAdmin()):

			if ($orderBy = $this->Data->get['orderby'] ?? 'id'):

				$articles = $this->articlesManager->findAllOrderBy($this->Data->get['orderby'])->fetchAll();

			endif;

			if ($articles):

				$responseArray = array();

				foreach ($articles as $article):

					$postArray = ["entity" => "article", "id" => $article->id(), "title" => $article->title(), "excerpt" => $article->contentExcerpt(60), "chapterId" => $article->chapterNumber(), 'update' => $article->updateDate(), 'type' => $article->type()];

					$responseArray[] = (object) $postArray;

				endforeach;

				echo json_encode($responseArray);
			endif;

		endif;
	}

	public function saveAction() {

		if ($this->user->isAuthentifiedAdmin()):

			$pictureName = null;

			if (($title = $this->Data->post['title'] ?? false) && ($chapternumber = $this->Data->post['chapternumber'] ?? false) && ($content = $this->Data->post['content'] ?? false) && ($type = $this->Data->post['type'] ?? false)):

				if (!empty($_FILES) AND !empty($_FILES['picture']) && !empty($_FILES['picture']['name'])):

					$picture = new Picture($_FILES['picture']);

					if (!$picture->hasErrors()):
						$pictureName = $this->uploadPicture($picture);
					else:
						echo "une erreur est survenue avec l'image choisie";
						exit;
					endif;
				endif;

				echo $this->articlesManager->save($title, $chapternumber, $content, $type, $pictureName, $this->Data->post['id'] ?? null);

			else:
				echo "Des champs obligatoire ne sont pas remplis";
			endif;

		else:
			header("Location: /");
		endif;
	}

	private function uploadPicture(Picture $picture) {

		$this->picturesManager = new PicturesManager();

		return $this->picturesManager->uploadPicture($picture);

	}

	public function editAction() {

		if ($this->user->isAuthentifiedAdmin()):

			if ($id = $this->Data->get['id'] ?? false):

				$article = $this->articlesManager->find($id)->fetch();

				$postArray = ["entity" => "article", "id" => $article->id(), "title" => $article->title(), "content" => $article->content(), "chapterId" => $article->chapterNumber(), 'type' => $article->type(), 'pictureName' => $article->pictureName()];

				echo json_encode((object) $postArray);

			endif;

		else:
			echo false;
		endif;
	}

	public function deleteAction() {

		if ($this->user->isAuthentifiedAdmin()):

			if ($id = $this->Data->get['id'] ?? false):
				echo $this->articlesManager->delete($id);
			endif;

		endif;
	}
}