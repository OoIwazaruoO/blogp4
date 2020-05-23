<?php

namespace Entities;

use Core\Entity;

class Comment extends Entity {

	protected $articleId,
	$author,
	$content,
	$creationDate,
	$reported,
		$status;

	const INVALID_AUTHOR = "Il ya une erreur dans le nom de l'auteur";
	const INVALID_CONTENT = "Il y a une erreur dans le contenu du commentaire";

	public function isValid() {
		return !empty($this->pseudo) and !empty($this->content);
	}

	public function setArticleId($articleId) {
		$this->articleId = (int) $articleId;
	}

	public function setAuthor($author) {
		if (is_string($author) and !empty($author) and strlen($author) < 16) {
			$this->author = $author;
		} else {
			$this->errors[] = self::INVALID_AUTHOR;
		}
	}

	public function setContent($content) {
		if (!empty($content) && is_string($content) and strlen($content) < 256 and strlen($content) >= 4) {
			$this->content = $content;
		} else {
			$this->errors[] = self::INVALID_CONTENT;
		}
	}

	public function setReported($isReported) {
		$this->reported = (bool) $isReported;
	}

	public function setStatus($status) {
		$this->status = $status;
	}

	public function setCreationDate($date) {
		$this->creationDate = $date;
	}

	public function getFormatedDate() {
		return date('\L\e d-m-Y à H\hi\m\i\ns\s', strtotime($this->creationDate));
	}

	public function articleId() {return $this->articleId;}
	public function author() {return $this->author;}
	public function content() {return $this->content;}
	public function creationDate() {return $this->creationDate;}
	public function reported() {return $this->reported;}
	public function status() {return $this->status;}

}