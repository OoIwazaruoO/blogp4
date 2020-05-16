<?php

namespace Managers;

use Entities\Article;
use Core\Manager;

class ArticlesManager extends Manager{

	public function __construct($dao, $table, $classname){
		parent::__construct($dao, $table, $classname);
	}


}