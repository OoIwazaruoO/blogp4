<?php

namespace Core;

class View{

	protected $viewsPath;
	protected $template;

	public function __construct($viewsPath, $template){
		$this->setViewsPath($viewsPath);
		$this->setTemplate($template);
	}


	public function render($view, $data = []){
		
		ob_start();
		extract($data);
		require($this->viewsPath . str_replace('.', '/', $view) . 'View.php');

		$content = ob_get_clean();

		require($this->viewsPath . 'templates/' . $this->template . '.php');
	}

	public function setViewsPath($viewsPath){
		$this->viewsPath = $viewsPath;
	}

	public function setTemplate($template){
		$this->template = $template;
	}
}