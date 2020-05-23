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

	public function confirm($login) {

		$req = $this->dao->prepare("UPDATE {$this->targetTable} SET confirmed = 1 WHERE login = :login");

		$req->execute(array(':login' => $login));

	}

	public function add($login, $password, $mail) {

		if (!$this->userExist($login, $mail)) {
			$date = time();
			$stringToToken = $date . $login;

			$confirmationToken = password_hash($stringToToken, PASSWORD_DEFAULT);
			$confirmationToken = str_replace('/', '', $confirmationToken);
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

	public function bann($id = null) {

		if ($id != null):
			$req = $this->dao->prepare("UPDATE {$this->targetTable} SET banned = 1 WHERE id = :id");
			return $req->execute(array(":id" => $id));
		endif;

		return false;

	}

	public function findAllOrderBy($orderby = "id") {

		$possibleOrderBy = array("id", "inscriptionDate", "role", "login");

		$index = array_search($orderby, $possibleOrderBy);

		if (!$index):
			$orderby = "id";
		endif;

		$result = $this->dao->query("SELECT * from {$this->targetTable} ORDER BY {$orderby}");

		$result->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $this->className);

		return $result;

	}

	public function sendVerificationMail($login, $mail, $confirmationToken) {

		$login = $login;
		$mail = $mail;
		$confirmationToken = $confirmationToken;

		$our_email = "noreply@jeanforteroche.com";
		$to = $mail;
		$from = $our_email;
		$subject = "Confirmez votre inscription - Billet simple pour l'Alaska";
		$message =
			"<html>
        <body>
        <p>Cliquez ici pour confirmer votre inscription <a href=\"localhost/users/confirm/login/{$login}/token/{$confirmationToken}\">Confirmer l'inscription!!!</a></p>
        </body>
        </html>";

		$headers = "From: $from\r\n";
		$headers .= "Content-type: text/html\r\n";
		$mail = mail($to, $subject, $message, $headers);

	}

}