<?php
namespace Controllers;

use Core\MyController;
use Managers\UsersManager;

class UsersController extends MyController {

	public function __construct($actionData) {

		parent::__construct($actionData);

		$this->usersManager = new UsersManager($this->dao, "users", 'Entities\\User');

	}

	public function indexAction() {
		if (empty($_SESSION['auth'])):
			$this->connectionFormAction();
		else:
			$this->leadUser();
		endif;
	}

	public function connectionFormAction() {
		$this->view->render('connection');
	}

	private function leadUser() {

		if ($this->user->isAuthentifiedAdmin()):
			header("Location: /master");
		else:
			$this->userProfil();
		endif;

	}

	private function userProfil() {

		$user = $this->usersManager->find($_SESSION['auth']['id'])->fetch();

		$this->view->render("profil", compact('user'));
	}

	public function getListAction() {

		if ($this->user->isAuthentifiedAdmin()):

			if ($orderBy = $this->Data->get['orderby'] ?? 'id'):
				$users = $this->usersManager->findAllOrderBy($orderBy)->fetchAll();
			endif;

			if ($users):

				$responseArray = array();

				foreach ($users as $user):

					if ($user->login() != $_SESSION['auth']['login']):

						$postArray = ["entity" => "user", "id" => $user->id(), "login" => strip_tags($user->login()), "inscriptionDate" => $user->inscriptionDate(), "role" => $user->role(), 'confirmed' => $user->confirmed(), "banned" => $user->banned()];
						$responseArray[] = (object) $postArray;

					endif;

				endforeach;

				echo json_encode($responseArray);

			endif;

		endif;

	}

	public function connectAction() {

		$_SESSION['flash']['error'] = [];

		if (($login = $this->Data->post['login'] ?? false) && ($pass = $this->Data->post['password'] ?? false)):

			$user = $this->usersManager->findByLogin($login)->fetch();

			if ($user):

				if (password_verify($pass, $user->password())):

					if (!$user->isAllowed()):
						$_SESSION['flash']['error'][] = "Ce compte est innaccessible";
					else:
						$_SESSION['flash']['success'] = [];
						$_SESSION['flash']['success'][] = "Vous êtes connecté!";
						$user->authentify();
					endif;

				else:
					$_SESSION['flash']['error'][] = "informations de connexion incorrectes";
				endif;

			else:
				$_SESSION['flash']['error'][] = "informations de connexion incorrectes";
			endif;

		else:
			$_SESSION['flash']['error'][] = "Veuillez renseignez les deux champs";
		endif;

		header("Location: /users");
		exit;

	}

	public function logoutAction() {

		if ($this->user->isAuthentified()):

			$this->destroySession();
			$this->startSessionIfNotStarted();

			$_SESSION['flash']['success'] = [];
			$_SESSION['flash']['success'][] = "Vous êtes déconnecté";

		else:
			$_SESSION['flash']['error'] = [];
			$_SESSION['flash']['error'][] = "Vous n'êtes pas connecté";
		endif;

		header("location: /");
	}

	public function bannAction() {

		if ($this->user->isAuthentifiedAdmin()):

			if ($id = $this->Data->get['id']):

				if ($id != $_SESSION['auth']['id']):
					echo $this->usersManager->bann($id);
				else:
					echo "Vous ne pouvez vous pas vous bannir vous même";
				endif;

			endif;

		endif;

	}

	public function unbannAction() {

		if ($this->user->isAuthentifiedAdmin()):

			if ($id = $this->Data->get['id']):

				if ($id != $_SESSION['auth']['id']):
					echo $this->usersManager->unbann($id);
				else:
					echo "impossible de débannir cet utilisateur";
				endif;

			endif;

		endif;

	}

}