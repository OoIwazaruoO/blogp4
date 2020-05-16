<?php
namespace Controllers;

use Core\MyController;
use Managers\ArticlesManager;

class ArticlesController extends MyController{

	public function __construct($actionData){
		parent::__construct($actionData);

		$this->articlesManager = new ArticlesManager($this->dao, "posts", 'Entities\\Article');

	}

	public function indexAction(){
		$articles = $this->articlesManager->findAll();
		
		$this->view->render("blog", compact('articles'));
	}

	public function readAction(){
		
		if($id = !empty($this->Data->get['id']) ? $this->Data->get['id'] : null){
			$article = $this->articlesManager->find($id);
			
			$this->view->render("read",compact('article'));		
			exit;
		}

		header("location: /");
	}

}