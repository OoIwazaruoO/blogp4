<?php

namespace Entities;

use Core\Entity;

class Article extends Entity{

	protected $title;
	protected $content;
	protected $creationDate;
	protected $updateDate;
	protected $type;
	protected $pictureName;
	protected $chapterNumber;

	const INVALID_TITLE   = "Le titre de l'article  n'est pas valide";
	const INVALID_CONTENT = "Le contenu de l'article n'est pas valide";
	const INVALID_TYPE    = "Le type de l'articles n'est pas valide";

	public function __construct($data = []){
		parent::__construct($data);
	}

	public function setTitle($title)
	{
		if (is_string($title) && !empty($title)) {
			$this->title = $title;
		} else {
			$this->errors[] = self::INVALID_TITLE;
		}
	}

	public function setContent($content)
	{
		if (!empty($content) && is_string($content)) {
			$this->content = $content;
		} else {
			$this->errors[] = self::INVALID_CONTENT;
		}
	}

	public function setCreationDate(\DateTime $date)
	{
		$this->creationDate = $date;
	}

	public function setUpdateDate(\DateTime $date)
	{
		$this->updateDate = $date;
	}

	public function setType($type)
	{
		if ($type == 'published' || $type == 'draft') {
			$this->type = $type;
		} else {
			$this->errors[] = self::INVALID_TYPE;
		}
	}

	public function setPicture($pictureName)
	{
		$this->pictureName = $pictureName;
	}

	public function setViewsNumber($viewsNumber)
	{
		$this->viewsNumber = (int) $viewsNumber;
	}

	public function setChapterNumber($chapterNumber){

	}

	public function contentExcerpt($length)
	{
		$excerpt = substr($this->content, 0, $length);
		$excerpt = strip_tags($excerpt);

		return $excerpt . ' ...';
	}

	public function getFormatedCreationDate(){
		return $this->formatDate($this->creationDate);
	}

	public function getFormatedUpdateDate(){
		return $this->formatDate($this->updateDate);
	}

	private function formatDate($date){
		return date('\L\e d-m-Y à H\hi\m\i\ns\s', strtotime($date));
	}


	public function title()
	{return $this->title;}
	public function content()
	{return $this->content;}
	public function creationDate()
	{return $this->creationDate;}
	public function updateDate()
	{return $this->updateDate;}
	public function type()
	{return $this->type;}
	public function pictureName()
	{return $this->pictureName;}
	public function chapterNumber()
	{return $this->chapterNumber;}

	


}