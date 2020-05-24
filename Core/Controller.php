<?php

namespace Core;

abstract class Controller {

	public function __construct($actionData) {

		$this->Data = $actionData;

	}

	protected function startSessionIfNotStarted() {
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}
	}

	protected function destroySession() {

		$this->startSessionIfNotStarted();

		$_SESSION = array();
		session_destroy();
	}

	public function createSessionToken() {
		$this->startSessionIfNotStarted();

		if (!empty($_SESSION['tokenExpirationTime']) && !empty($_SESSION['token'])) {
			$this->certifiedToken = $this->compareTokens();

			if (time() > $_SESSION['tokenExpirationTime']) {
				unset($_SESSION['tokenExpirationTime']);
				unset($_SESSION['token']);
			}
		}

		if (empty($_SESSION['tokenExpirationTime']) || empty($_SESSION['token'])) {
			$_SESSION['token'] = bin2hex(random_bytes(16));
			$_SESSION['tokenExpirationTime'] = time() + (2 * 60);
		}
	}

	public function setToken($token = "false") {
		$this->token = !empty($token) ? $token : null;
	}

	public function compareTokens() {
		$this->startSessionIfNotStarted();

		return empty($this->token) ? false : $this->token === $_SESSION['token'] ? true : false;
	}

}