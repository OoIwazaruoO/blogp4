<?php
namespace Controllers;

use Core\MyController;
use Entities\User;
use Managers\UsersManager;

class UsersController extends MyController {

	public function __construct($actionData) {

		parent::__construct($actionData);
		$this->startSessionIfNotStarted();

		$this->user = new User();
		$this->usersManager = new UsersManager($this->dao, "users", 'Entities\\User');

	}

	public function indexAction() {
		if (empty($_SESSION['auth'])):
			$this->connectionFormAction();
		else:
			$this->leadUser();
		endif;
	}

	public function inscriptionFormAction() {
		$this->view->render('inscription', array(), array('checkInscription'));
	}

	public function registerAction() {

		$_SESSION['flash']['error'] = [];

		$this->checkRegisterFormData();

		$userData = array("login" => $this->Data->post['login'],
			"mail" => $this->Data->post['mail'],
			"password" => $this->Data->post['pass1']);

		$this->user->hydrate($userData);

		foreach ($this->user->errors() as $error):
			$_SESSION['flash']['error'][] = $error;
		endforeach;

		if (!empty($_SESSION['flash']['error'])):
			header("Location: /users/inscriptionForm");
			exit;
		endif;

		if ($this->usersManager->add($this->user->login(), $this->user->password(), $this->user->mail())):

			$_SESSION['flash']['success'] = [];
			$_SESSION['flash']['success'][] = "Un email de confirmation vient de vous etre envoyé à l'adresse {$this->user->mail()} ";

			header("Location: /users");
			exit;
		else:

			$_SESSION['flash']['error'][] = 'Ce pseudo ou ce mail est déjà utilisé';
			header("Location: /users/inscriptionForm");
			exit;

		endif;

	}

	public function confirmAction() {

		$_SESSION['flash']['error'] = [];
		$_SESSION['flash']['success'] = [];

		if (!empty($this->Data->get['login']) && !empty($this->Data->get['token'])):

			$login = $this->Data->get['login'];
			$token = $this->Data->get['token'];

			if ($user = $this->usersManager->findByLogin($login)->fetch()):

				if (!$user->confirmed()):

					$time1 = time();
					$time2 = strtotime($user->confirmationDate());

					if ($time1 > $time2):
						$_SESSION['flash']['error'][] = "Le lien est expiré";
					else:
						if ($token == $user->confirmationToken()):
							$this->usersManager->confirm($login);
							$_SESSION['flash']['success'][] = "Compte confirmé, vous pouvez vous connecter";
						else:
							$_SESSION['flash']['error'][] = "Le lien que vous avez suivi est erronné";
						endif;

					endif;

				else:
					$_SESSION['flash']['success'][] = "Votre compte est déjà confirmé";
				endif;

			else:
				$_SESSION['flash']['error'][] = "Le lien que vous avez suivi est erronné";
			endif;

		else:
			$_SESSION['flash']['error'][] = "Le lien que vous avez suivi est erronné";
		endif;

		header("Location: /users");

	}

	public function connectionFormAction() {
		$this->view->render('connection');
	}

	public function connectAction() {

		$_SESSION['flash']['error'] = [];

		if (!empty($this->Data->post) && !empty($this->Data->post['login']) && !empty($this->Data->post['password'])):

			$user = $this->usersManager->findByLogin($this->Data->post['login'])->fetch();

			if ($user):

				if (password_verify($this->Data->post['password'], $user->password())):
					if (!$user->isAllowed()):
						$_SESSION['flash']['error'][] = "Ce compte est innaccessible";
					else:
						$_SESSION['flash']['success'] = [];
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

	private function checkRegisterFormData() {

		if (!empty($this->Data) && !empty($this->Data->post)):

			if (empty($this->Data->post['login'])):
				$_SESSION['flash']['error'][] = "Veuillez renseigner un pseudo";
			endif;

			if (empty($this->Data->post['mail'])):
				$_SESSION['flash']['error'][] = "Veuillez renseigner l'e-mail";
			endif;

			if (!empty($this->Data->post['pass1']) && !empty($this->Data->post['pass2'])):

				if ($this->Data->post['pass1'] != $this->Data->post['pass2']):
					$_SESSION['flash']['error'][] = "Les mots de passes doivent être identiques";
				endif;

			else:
				$_SESSION['flash']['error'][] = "Veuillez renseigner les deux champs mot de passe";
			endif;

		else:
			$_SESSION['flash']['error'][] = "Aucunes informations reçues";
		endif;

		if (!empty($_SESSION['flash']['error'])):
			header("Location: /users/inscriptionForm");
			exit;
		endif;

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

}