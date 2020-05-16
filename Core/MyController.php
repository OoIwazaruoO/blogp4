<?php

namespace Core;

abstract class MyController extends Controller{

	public function __construct($actionData){
		parent::__construct($actionData);
		$this->dao = DBFactory::getMysqlConnexionWithPDO();
		$this->view = new View(__DIR__."/../App/Views/", "template");
	}

}