<?php
namespace Controllers;

use Core\MyController;

class LegalController extends MyController {

	public function __construct($actionData) {

		parent::__construct($actionData);

	}

	public function indexAction() {

		$website = "addresse web";
		$owner = "Nom du propriétaire";
		$ownerAddress = "addresse du propriétaire";
		$ownerMail = "mail du propriétaire";

		$this->view->render("legal", compact('website', 'owner', 'ownerAddress', 'ownerMail'));

	}
}