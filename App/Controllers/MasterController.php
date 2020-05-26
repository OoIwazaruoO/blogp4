<?php
namespace Controllers;

use Core\MyController;

class MasterController extends MyController {

	public function __construct($actionData) {

		parent::__construct($actionData);

	}

	public function indexAction() {

		if ($this->user->isAuthentifiedAdmin()):
			$this->view->render('master', [], array('ArticlesCommentsUsers', 'master'));
		else:
			throw new \Exception("Cette page n'existe pas");
		endif;

	}
}