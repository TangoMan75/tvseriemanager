<?php

namespace Controller;

use \W\Controller\Controller;

class ProfileController extends Controller
{

	/**
	 * Page de profil avec liste des séries.
	 * 
	 * @deprecated 1.0
	 */
	public function profile()
	{
		if (!$this->getUser()){
			$this->redirectToRoute("register");
		}
		$this->show('profile/profile');
	}

	/**
	 * Page pour changer de username.
	 * 
	 * @deprecated 1.0
	 */
	
	public function username()
	{	
		$error = "";
		$username = "";

		if($username){
			$username = $_POST['username'];

			$user = $userManager->getUserByUsernameOrEmail($email);

			$isValid = true;

			if (empty($username)){
				$isValid = false;
				$error = "Please put a username";
			} elseif ($userManager->getUserByUsernameOrEmail($username)){
				$isValid = false;
				$error = "Username already use";
			} elseif (strlen($username) < 2) {
				$isValid = false;
				$error = "Username too short !";
			}
		}
		$userManager = new \Manager\UserManager();
		
		$userManager->update([
			'username' => $username
		], $user['id']);

		$this->show('profile/username', [
			"error" => $error,
			"username" => $username
		]);
	}
}