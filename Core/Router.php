<?php
namespace Core;


class Router{

	private $controller = "HomeController";
	private $action = "indexAction";
	private $url;
	private $urlData;
	private $actionData;


	public function __construct($controllerNamespace){

		$this->url = trim($_SERVER['REQUEST_URI'], '/');
		$this->controllerNamespace = $controllerNamespace;
		$this->parseUrl();
		$this->callControllerMethod($this->controllerNamespace);
		

	}

	public function parseUrl(){

		$this->urlData = explode('/', $this->url);

		$this->setControllerFromUrlData();
		$this->setActionFromUrlData();
		$this->setActionDataFromUrlData();
		
	}
	//set the controller if the is one in the first part of the url
	private function setControllerFromUrlData(){

		$this->controller = !empty($this->urlData[0])  ? ucfirst(strtolower($this->urlData[0])) . 'Controller' : $this->controller;

	}
	//set the controller if the is one in the second part of the url
	private function setActionFromUrlData(){

		$this->action = !empty($this->urlData[1])  ? lcfirst($this->urlData[1]) . 'Action' : $this->action;

	}

	//Check if there is action data in the rest of the url and set them in actionData
	private function setActionDataFromUrlData(){

		$this->actionData = new \stdClass();

		$dataNumber = count($this->urlData);

		//check if there is data action data and that the url is in the correct format 
		if($dataNumber > 2 && $dataNumber % 2 == 0){

			//set the data by key value
			for($i = 2; $i < $dataNumber; $i = $i + 2){
				$key = strtolower($this->urlData[$i]);
				$value = $this->urlData[$i + 1];

				$this->actionData->get[$key] = $value;
			}

		}
		//add $_POST data in the actionData
		$this->actionData->post = $_POST;
	}

	private function callControllerMethod($controllerNamespace){

		$path = '../App/Controllers/'.$this->controller.'.php';

		if(file_exists($path)){
			require_once $path;
			$controller = $controllerNamespace.$this->controller;
			$this->controller = new $controller($this->actionData);

			if(method_exists($this->controller, $this->action)){

				$action = $this->action;
				$this->controller->$action();

			}
			else{
				throw new \Exception("Page introuvable");
			}
			
		}else{
			throw new \Exception("Page introuvable");
		}
	}

}