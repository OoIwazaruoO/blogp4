<?php
namespace Controllers;

use Core\MyController;
use Entities\Comment;

class CommentsController extends MyController {

	public function __construct($actionData) {

		parent::__construct($actionData);

		$this->comment = new Comment();

	}

	public function getListAction() {

		if ($this->user->isAuthentifiedAdmin()):

			if ($orderBy = $this->Data->get['orderby'] ?? 'id'):
				$comments = $this->commentsManager->findAllOrderBy($this->Data->get['orderby'])->fetchAll();
			endif;

			if ($comments):

				$responseArray = array();

				foreach ($comments as $comment):
					$postArray = ["entity" => "comment", "id" => $comment->id(), "author" => strip_tags($comment->author()), "content" => strip_tags($comment->content()), "creationDate" => $comment->getFormatedDate(), 'status' => $comment->status(), "articleId" => $comment->articleId(), "reported" => $comment->reported()];
					$responseArray[] = (object) $postArray;
				endforeach;

				echo json_encode($responseArray);
			endif;

		endif;
	}

	public function addAction() {

		$_SESSION['flash']['error'] = [];
		$_SESSION['flash']['success'] = [];

		if ($this->user->isAuthentified()):

			$articleId = $this->Data->post['id'] ?? null;
			$content = $this->Data->post['content'] ?? null;
			$author = $_SESSION['auth']['login'];

			$article = $this->articlesManager->find($articleId)->fetch();

			if ($article && $article->type() == "published"):

				$this->comment->hydrate(array("articleId" => $articleId, "author" => $author, "content" => $content));

				if ($this->comment->hasErrors()):

					foreach ($this->comment->errors() as $error):
						$_SESSION['flash']['error'][] = $error;
					endforeach;

				else:

					if ($this->commentsManager->add($articleId, $author, $content)):
						$_SESSION['flash']['success'][] = "Votre commentaire a bien était ajouté";

					else:
						$_SESSION['flash']['error'][] = "Une erreur est survenu lors de l'ajout de votre commentaire, si le problème persiste merci de contacter l'administrateur du site";
					endif;

				endif;

				header("Location: /articles/read/id/" . $articleId);
				exit;

			else:
				$_SESSION['flash']['error'][] = "Cet article n'existe pas";
			endif;

		else:
			$_SESSION['flash']['error'][] = "Vous devez être authentifié pour commenter un article";
		endif;

		header(("Location: /articles"));

	}

	public function editAction() {

		if ($this->user->isAuthentifiedAdmin()):

			if ($id = $this->Data->get['id'] ?? false):

				$comment = $this->commentsManager->find($id)->fetch();

				$postArray = ["entity" => "comment", "id" => $comment->id(), "content" => $comment->content(), "author" => $comment->author()];

				echo json_encode((object) $postArray);

			endif;

		else:
			echo false;
		endif;

	}

	public function saveEditedAction() {

		if ($this->user->isAuthentifiedAdmin()):

			if (($commentId = $this->Data->post['commentId'] ?? false) && ($commentContent = $this->Data->post['commentContent'] ?? false)):
				echo $this->commentsManager->adminEdit($commentContent, $commentId);
			else:
				echo "Des données sont manquantes";
			endif;

		else:
			echo false;
		endif;
	}

	public function deleteAction() {

		if ($this->user->isAuthentifiedAdmin()):

			if ($id = $this->Data->get['id']):
				echo $this->commentsManager->setAsDeleted($id);
			endif;

		endif;

	}

}