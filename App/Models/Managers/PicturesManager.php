<?php

namespace Managers;

use Entities\Picture;

class PicturesManager {

	public function uploadPicture(Picture $picture) {
		if (!$picture->hasErrors()) {

			$pictureName = uniqid() . $picture->getExtension();

			if (move_uploaded_file($picture->tmpName(), __ROOT__ . $picture->folder() . $pictureName)):
				return $pictureName;
			else:
				return false;
			endif;
		} else {
			throw new Exception("L'image a des erreurs et ne peux pas être uploadée.");
		}
	}

}
