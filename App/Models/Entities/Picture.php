<?php

namespace Entities;

use Core\Entity;

class Picture extends Entity {

	protected $folder = '/images/',
	$maxSize = 2097152,
	$extensions = array('.png', '.gif', '.jpg', '.jpeg');

	const INVALID_SIZE = 1;
	const INVALID_TYPE = 2;

	public function __construct(array $pictureData) {
		parent::__construct($pictureData);
		$this->checkSize();
		$this->checkExtension();
	}

	public function setName($name) {
		$this->name = basename($name);
		$this->name = strtr($this->name, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
		$this->name = preg_replace('/([^.a-z0-9]+)/i', '-', $this->name);
	}

	public function setTmp_name($tmp_name) {
		$this->tmpName = $tmp_name;
	}

	public function setType($type) {
		$this->type = $type;
	}

	public function setSize($size) {
		$this->size = $size;
	}

	public function checkSize() {
		$size = filesize($this->tmpName);

		if ($size > $this->maxSize || $size === 0) {
			$this->errors[] = self::INVALID_SIZE;
		}
	}

	public function checkExtension() {
		$extension = strrchr($this->name, '.');

		if (!in_array($extension, $this->extensions)) {
			$this->errors[] = self::INVALID_TYPE;
		}
	}

	public function getExtension() {
		return strrchr($this->name, '.');
	}

	public function getErrorMessage() {
		$errorMessage = '';

		foreach ($this->errors as $error) {
			switch ($error) {
			case self::INVALID_SIZE:
				$errorMessage += "Le fichier est trop volumineux.\n";
				break;
			case self::INVALID_TYPE:
				$errorMessage += "Seul les fichier gif, png et jpg sont autorisés.\n";
				break;
			default:
				$errorMessage += "Une erreur est survenu avec votre fichier. \n";
				break;
			}
		}

		return $errorMessage;
	}

	public function name() {return $this->name;}
	public function tmpName() {return $this->tmpName;}
	public function type() {return $this->type;}
	public function size() {return $this->tize;}
	public function folder() {return $this->folder;}
}
