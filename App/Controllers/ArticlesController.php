<?php
namespace Controllers;

use Core\MyController;
use Managers\ArticlesManager;

class ArticlesController extends MyController{

	public function __construct($actionData){
		parent::__construct($actionData);

		$this->articleManager = new ArticlesManager($this->dao, "posts", 'Entities\\Article');

	}

	public function indexAction(){
		$articles = $this->articleManager->findAll();
		
		$this->view->render("blog", compact('articles'));
	}

}