<?php

namespace Core;

abstract class Controller{

	public function __construct($actionData){

		$this->Data = $actionData;

	}

	protected function startSessionIfNotStarted(){
		if (session_status() == PHP_SESSION_NONE)
		{
			session_start();
		}
	}

	protected function destroySession(){

		$this->startSessionIfNotStarted();

		$_SESSION = array();
		session_destroy();
	}


}