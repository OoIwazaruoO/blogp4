<?php
namespace Controllers;

use Core\MyController;
use Entities\Comment;
use Entities\User;
use Managers\ArticlesManager;
use Managers\CommentsManager;

class CommentsController extends MyController {

	public function __construct($actionData) {
		parent::__construct($actionData);

		$this->startSessionIfNotStarted();

		$this->user = new User();
		$this->articlesManager = new ArticlesManager($this->dao, "posts", 'Entities\\Article');

		$this->comment = new Comment();
		$this->commentsManager = new CommentsManager($this->dao, "comments", 'Entities\\Comment');

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

					foreach ($this->comment->errors() as $error) {
						$_SESSION['flash']['error'][] = $error;
					} else :

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
				header(("Location: /articles"));
			endif;

		else:
			$_SESSION['flash']['error'][] = "Vous devez être authentifié pour commenter un article";
			header("Location: /articles");
		endif;

	}

}