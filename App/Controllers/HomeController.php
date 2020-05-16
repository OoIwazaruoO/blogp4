<?php
namespace Controllers;

use Core\MyController;
class HomeController extends MyController{

	public function __construct($actionData){
		parent::__construct($actionData);		
	}

	public function indexAction(){
		$this->view->render("home");
	}

}