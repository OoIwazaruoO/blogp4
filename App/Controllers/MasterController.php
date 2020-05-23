<?php
namespace Controllers;

use Core\MyController;
use Entities\Picture;
use Entities\User;
use Managers\ArticlesManager;
use Managers\CommentsManager;
use Managers\PicturesManager;
use Managers\UsersManager;

class MasterController extends MyController {

	public function __construct($actionData) {
		parent::__construct($actionData);

		$this->startSessionIfNotStarted();

		$this->user = new User();
		$this->articlesManager = new ArticlesManager($this->dao, "posts", "Entities\\Article");
		$this->commentsManager = new CommentsManager($this->dao, "comments", "Entities\\Comment");
		$this->usersManager = new UsersManager($this->dao, "users", "Entities\\User");

	}

	public function indexAction() {

		if ($this->user->isAuthentifiedAdmin()):

			$this->view->render('master', [], array('master', 'masterAddEditDelete'));

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

		foreach ($articles as $article):
			$postArray = ["entity" => "article", "id" => $article->id(), "title" => $article->title(), "excerpt" => $article->contentExcerpt(60), "chapterId" => $article->chapterNumber(), 'update' => $article->updateDate(), 'type' => $article->type()];
			$responseArray[] = (object) $postArray;
		endforeach;

		echo json_encode($responseArray);

	}

	private function getCommentsList() {

		if (!empty($this->Data->get['orderby'])):
			$comments = $this->commentsManager->findAllOrderBy($this->Data->get['orderby'])->fetchAll();

		else:
			$comments = $this->commentsManager->findAll()->fetchAll();
		endif;

		$responseArray = array();

		foreach ($comments as $comment):
			$postArray = ["entity" => "comment", "id" => $comment->id(), "author" => $comment->author(), "content" => $comment->content(), "creationDate" => $comment->getFormatedDate(), 'status' => $comment->status(), "articleId" => $comment->articleId(), "reported" => $comment->reported()];
			$responseArray[] = (object) $postArray;
		endforeach;

		echo json_encode($responseArray);

	}

	private function getUsersList() {

		if (!empty($this->Data->get['orderby'])):
			$users = $this->usersManager->findAllOrderBy($this->Data->get['orderby'])->fetchAll();

		else:
			$users = $this->usersManager->findAll()->fetchAll();
		endif;

		$responseArray = array();

		foreach ($users as $user):
			$postArray = ["entity" => "user", "id" => $user->id(), "login" => $user->login(), "inscriptionDate" => $user->inscriptionDate(), "role" => $user->role(), 'confirmed' => $user->confirmed(), "banned" => $user->banned()];
			$responseArray[] = (object) $postArray;
		endforeach;

		echo json_encode($responseArray);

	}

	public function saveArticleAction() {

		if ($this->user->isAuthentifiedAdmin()):

			$pictureName = null;

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

					$id = !empty($this->Data->post['id']) ?? null;

					echo $this->articlesManager->save($title, $chapternumber, $content, $type, $pictureName, $id);

				else:
					echo "Des champs obligatoires ne sont pas remplis";
				endif;

			else:
				echo "Des champs obligatoire ne sont pas remplis";
			endif;

		else:
			header("Location: /");
		endif;

	}

	public function saveEditedCommentAction() {

		if ($this->user->isAuthentifiedAdmin()):

			if (!empty($this->Data->post)):

				if (!empty($this->Data->post['commentId']) && !empty($this->Data->post['commentContent'])):
					echo $this->commentsManager->adminEdit($this->Data->post['commentContent'], $this->Data->post['commentId']);
				else:
					echo "Des données sont manquantes";
				endif;

			endif;

		else:
			echo false;
		endif;

	}

	private function uploadPicture(Picture $picture) {

		$this->picturesManager = new PicturesManager();

		return $this->picturesManager->uploadPicture($picture);

	}

	public function editAction() {

		if ($this->user->isAuthentifiedAdmin()):

			if ($target = $this->Data->get['target']):

				if ($id = $this->Data->get['id']):

					switch ($target):
				case "article":
					$article = $this->articlesManager->find($id)->fetch();

					$postArray = ["entity" => "article", "id" => $article->id(), "title" => $article->title(), "content" => $article->content(), "chapterId" => $article->chapterNumber(), 'type' => $article->type(), 'pictureName' => $article->pictureName()];

					echo json_encode((object) $postArray);
					break;

				case "comment":

					$comment = $this->commentsManager->find($id)->fetch();

					$postArray = ["entity" => "comment", "id" => $comment->id(), "content" => $comment->content(), "author" => $comment->author()];

					echo json_encode((object) $postArray);

					break;
				default:
					echo false;
					break;

					endswitch;

					exit;

				endif;

			endif;

			echo false;

		endif;

	}

	public function deleteAction() {

		if ($this->user->isAuthentifiedAdmin()):

			if ($target = $this->Data->get['target']):

				if ($id = $this->Data->get['id']):

					switch ($target):

				case 'article':
					echo $this->articlesManager->delete($id);
					break;
				case 'comment':
					echo $this->commentsManager->setAsDeleted($id);
					break;
				case "user":
					echo $this->usersManager->bann($id);
					break;
				default:
					echo false;
					break;

					endswitch;

					exit;

				endif;

				echo false;

			endif;

			echo false;

		endif;

	}

}