<?php
namespace Controllers;

use Core\MyController;
use Managers\UsersManager;

class RegistrationController extends MyController {

	public function __construct($actionData) {
		parent::__construct($actionData);

		$this->usersManager = new UsersManager($this->dao, "users", "Entities\\User");
	}

	public function indexAction() {
		$this->view->render('inscription', array(), array('checkInscription'));
	}

	public function registerAction() {

		$_SESSION['flash']['error'] = [];

		$this->checkRegisterFormData();

		$userData = array("login" => $this->Data->post['login'],
			"mail" => $this->Data->post['mail'],
			"password" => $this->Data->post['pass1']);

		$this->user->hydrate($userData);

		if ($this->user->hasErrors()):

			foreach ($this->user->errors() as $error):
				$_SESSION['flash']['error'][] = $error;
			endforeach;

			header("Location: /registration");
			exit;

		endif;

		if ($this->usersManager->add($this->user->login(), $this->user->password(), $this->user->mail())):

			$_SESSION['flash']['success'] = [];
			$_SESSION['flash']['success'][] = "Un email de confirmation vient de vous etre envoyé à l'adresse {$this->user->mail()} ";

			header("Location: /users");
			exit;
		else:

			$_SESSION['flash']['error'][] = 'Ce pseudo ou ce mail est déjà utilisé';
			header("Location: /registration");
			exit;

		endif;

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

	public function confirmAction() {

		$_SESSION['flash']['error'] = [];
		$_SESSION['flash']['success'] = [];

		if (($login = $this->Data->get['login'] ?? false) && ($token = $this->Data->get['token'] ?? false)):

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

}