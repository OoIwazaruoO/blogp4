<?php

namespace Managers;

use Core\Manager;

class UsersManager extends Manager {

	public function __construct($dao, $table, $classname) {
		parent::__construct($dao, $table, $classname);
	}

	public function findByMail($mail) {
		$req = $this->dao->prepare("SELECT * FROM {$this->targetTable}  WHERE mail = :mail");
		$req->bindValue(':mail', $user->mail);

		$req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $this->className);

		$req->execute();

		return $req;
	}

	public function findByLogin($login) {
		$req = $this->dao->prepare("SELECT * FROM  {$this->targetTable}  WHERE login = :login");
		$req->bindValue(':login', $login);
		$req->execute();

		$req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $this->className);

		return $req;
	}

	public function userExist($login, $mail) {

		$req = $this->dao->prepare("SELECT id FROM {$this->targetTable} WHERE login = :login OR mail = :mail");

		$req->execute(array(':login' => $login, ':mail' => $mail));

		return $req->fetch();

	}

	public function add($login, $password, $mail) {

		if (!$this->userExist($login, $mail)) {
			$date = time();
			$stringToToken = $date . $login;

			$confirmationToken = password_hash($stringToToken, PASSWORD_DEFAULT);
			$confirmationDate = date("Y-m-d H:i:s", $date + (60 * 60 * 24 * 2));
			$hashedPass = password_hash($password, PASSWORD_BCRYPT);

			$req = $this->dao->prepare("INSERT INTO {$this->targetTable}(login, password, mail, confirmationToken, confirmationDate) VALUES(:login, :password, :mail, :cfToken, :cfDate) ");

			$req->execute(array(':login' => $login,
				':password' => $hashedPass,
				':mail' => $mail,
				':cfToken' => $confirmationToken,
				':cfDate' => $confirmationDate));

			//$this->sendVerificationMail($login, $mail, $confirmationToken);

			return true;

		} else {
			return false;
		}

	}

	public function sendVerificationMail($login, $mail, $confirmationToken) {

		$login = $login;
		$mail = $mail;
		$confirmationToken = $confirmationToken;

		ob_start();

		require __DIR__ . "/../../Views/templates/confirmationMail.php";

		$content = ob_get_clean();

		mail($mail, "Confirmez votre inscription - Billet simple pour l'Alaska", $content);

	}

}