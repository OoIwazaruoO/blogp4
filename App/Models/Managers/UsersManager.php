<?php

namespace Managers;

use Entities\User;
use Core\Manager;

class UsersManager extends Manager{

	public function __construct($dao, $table, $classname){
		parent::__construct($dao, $table, $classname);
	}

    public function findByMail($mail)
    {
        $req = $this->dao->prepare("SELECT * FROM {$this->targetTable}  WHERE mail = :mail");
        $req->bindValue(':mail', $user->mail);

        $req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $this->className);

        $req->execute();
   
        return $req;
    }

    public function findByLogin($login)
    {
        $req = $this->dao->prepare("SELECT * FROM users WHERE {$this->targetTable} = :login");
        $req->bindValue(':login', $login);
        $req->execute();

        echo $req->rowCount();

        $req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $this->className);

        return $req->fetch();
    }

    public function userExist($login, $mail){

    	$req = $this->dao->prepare("SELECT id FROM {$this->targetTable} WHERE login = :login && mail = :mail");

    	 $req->execute(array(':login' => $login, ':mail' => $mail));

    	 return $req->fetch();


    }

    public function addUser($login, $password, $mail)
    {

    	if(!$this->userExist($login, $mail)){

    		$date = Date.now();
    		$stringToToken =  $date . $login;

    		$confirmationToken = password_hash($stringToToken, PASSWORD_DEFAULT);
    		$confirmationDate = $date + (60 * 60 * 24 * 2);
    		$hashedPass = password_hash($password, PASSWORD_BCRYPT);

    		$req = $this->dao->prepare('INSERT INTO users(login, password, mail, confirmationToken, confirmationToken) VALUES(:login, :password, :mail, :cfToken, :cfDate) ');

    		$req->execute([':login' => $login,
                		  ':password'  => $hashedPass,
                		  ':mail'  => $mail,
                		  ':cfToken' => $confirmationToken,
                		  'cfDate' => $confirmationDate]);

    		//$this->sendVerificationMail($login)

    		return true;

    	}
    	else{
    		return false;
    	}
        
    }

    public function sendVerificationMail($login, $mail, $confirmationToken){

    	ob_start();
		
		require(__DIR__."/../App/Views/templates/confirmationMail.php");

		$content = ob_get_clean();

		mail($mail, "Confirmez votre inscription - Billet simple pour l'Alaska", $content);

    }

}