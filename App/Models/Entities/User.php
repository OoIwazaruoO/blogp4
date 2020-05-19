<?php

namespace Entities;

use Core\Entity;

class User extends Entity
{
    protected $login;
    protected $password;
    protected $mail;
    protected $inscriptionDate;
    protected $confirmationToken;
    protected $confirmationDate;
    protected $confirmed;
    protected $role;
    protected $banned;

    const INVALID_MAIL  = "l'adresse e-mail n'est pas un valide";
    const INVALID_PASS  = "votre mot de passe est trop court";
    const INVALID_LOGIN = "Le pseudo choisi n'est pas valide";
    const NOT_CONFIRMED = "Vous n'avez pas confirmé votre inscription";
    const BANNED_USER   = "Utilisateur banni";

    public function isAuthentified()
    {
        return !empty($_SESSION['auth']);
    }

    public function isAuthentifiedAdmin(){
        return !empty($_SESSION['auth']) && $_SESSION['auth']['role'] == 'admin';
    }

    public function authentify(){

        $auth = array("id" => $this->id, "login" => $this->login, "role" => $this->role);
        $_SESSION['auth'] = $auth;
             
    }

    public function isValid()
    {
        return !empty($this->login) and !empty($this->pass) and !empty($this->mail);
    }

    public function isAllowed(){
        return !$this->banned && $this->confirmed;
    }

    public function setLogin($login)
    {
        if (strlen($login) < 16 and strlen($login) >= 3) {
            $this->login = $login;
        } else {
            $this->errors[] = self::INVALID_LOGIN;
        }

    }

    public function setPassword($password)
    {
        if (strlen($pass) >= 8) {
            $this->password = $password;
        } else {
            $this->errors[] = self::INVALID_PASS;
        }

    }

    public function setMail($mail)
    {
        if (filter_var($mail, FILTER_VALIDATE_EMAIL) and strlen($mail) < 61) {
            $this->mail = $mail;

        } else {
            $this->errors[] = self::INVALID_MAIL;
        }
    }

    public function setinscriptionDate($inscriptionDate){
        $this->inscriptionDate = $inscriptionDate;
    }    

    public function setConfirmationToken($confirmationToken){
        $this->confirmationToken = $confirmationToken;
    }

    public function setConfirmationDate($confirmationDate){
        $this->confirmationDate = $confirmationDate;
    }

    public function setRole($role){
        $this->role = $role;
    }

    public function setConfirmed($confirmed){
        $isConfirmed = (bool) $confirmed;

        if(!$isConfirmed){
            $this->errors[] = self::NOT_CONFIRMED;
        }
    }

    public function setBanned($banned){
        $isBanned = (bool) $banned;

        if($isBanned){
            $this->errors[] = self::BANNED_USER;
        }

        $this->banned =  $isBanned;
    }


    public function setSessionView($postId)
    {
        $_SESSION['postsViewed'][$postId] = true;
    }

    public function getSessionView($postId)
    {
        return isset($_SESSION['postsViewed'][$postId]) ? $_SESSION['postsViewed'][$postId] : null;
    }

    public function login() { return $this->login; }
    public function password() { return $this->password; } 
    public function mail() { return $this->mail; }
    public function inscriptionDate(){ return $this->inscriptionDate; }
    public function confirmationToken(){ return $this->confirmationToken; }
    public function confirmationDate(){ return $this->confirmationDate; }
    public function role(){ return $this->role; }
    public function confirmed(){ return $this->confirmed; }
    public function banned(){ return $this->banned; }

}
