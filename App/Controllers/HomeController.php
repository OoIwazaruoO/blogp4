<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;

class HomeController extends Controller{

	public function __construct($actionData){
		parent::__construct($actionData);

		$this->view = new View(__DIR__."/../Views/", "template");
	}

	public function indexAction(){
		$this->view->render("home");
	}

}