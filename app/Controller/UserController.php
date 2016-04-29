<?php

namespace Controller;

use \W\Controller\Controller;

/**
 * Controlleur de la page d'inscription.
 * 
 * @last_modified  23:35 03/02/2016
 * @author         Christian Marcucci <christian.marcucci13@gmail.com>
 * @copyright      2015-2016 - Matthias Morin, Full Stack Web Developer
 */
class UserController extends Controller
{

	/**
	 * Page d'inscription
	 */
	public function register()
	{

		$error = "";
		$username = "";
		$email = "";

		// Vérification de formulaire
		if ($_POST){
			$username     = $_POST['username'];
			$email        = $_POST['email'];
			$password     = $_POST['password'];
			$password_bis = $_POST['password_bis'];

			// validation des données
			$isValid = true;

			$userManager = new \Manager\UserManager;

			// username 
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

			// password
			if (empty($password) || empty($password_bis)) {
				$isValid = false;
				$error = "Password missing !";
			} elseif ($password != $password_bis){
				$isValid = false;
				$error = "Passwords are not the same !";
			} else if (strlen($password) < 5){
				$isValid = false;
				$error = "Password too short !";
			} 

			// Email 
			if ($userManager->getUserByUsernameOrEmail($email) ){
				$isValid = false;
				$error = "Email already used !";
			} elseif (!preg_match("/^[a-zA-Z0-9._-]+@[a-z0-9-]{1,67}\.[a-z]{2,67}$/", $email)) {
				$isValid = false;
				$error = "Email not valid";
			}

			$authentificationManager = new \W\Security\AuthentificationManager;

			// si c'est valide
			if ($isValid){
				// insertion en bdd
				$userManager->insert([
					"username" => $username,
					"email"    => $email,
					"password" => password_hash($password, PASSWORD_DEFAULT)
				]);
				// connexion du user
				$result = $authentificationManager->isValidLoginInfo( $username, $password);
				$user = $userManager->find($result);
				$authentificationManager->logUserIn($user);

				$this->redirectToRoute("profile");
			}
			
		}

		else {
			$error = "Please fill the form.";
		}

		$this->show('user/register', [
			"error"    => $error,
			"username" => $username,
			"email"    => $email	
		]);

	}

	/**
	 * Page de connexion
	 */

	public function login()
	{
		if (!empty($_POST)){
			$username = $_POST['username'];
			$password = $_POST['password'];

			$authentificationManager = new \W\Security\AuthentificationManager;
			$result = $authentificationManager->isValidLoginInfo( $username, $password);
			// connexion réussie
			if ($result){
				// on récupère le user en base de données
				$userManager = new \Manager\UserManager;
				$user = $userManager->find($result);

			// on le connecte
				$authentificationManager->logUserIn($user);
				$this->redirect($_SERVER['HTTP_REFERER']);		
			} 

			else {
				// message d'erreur à refaire 
				$this->redirectToRoute("register");
			}
			
		}

		$this->show("profile/profile");
	}

	/**
	 * Page de déconnexion
	 */

	public function logout()
	{
		$authentificationManager = new \W\Security\AuthentificationManager;

		$authentificationManager->logUserOut();

		$this->redirectToRoute("home");
	}

	/**
	 *  page password oublié
	 */

	public function password()
	{	
		
		$error = "";
		$email = "";

		// formulaire 
		if ($_POST){
			$email = $_POST['email'];

			$userManager = new \Manager\UserManager();
			$user = $userManager->getUserByUsernameOrEmail($email);

			if ($user){

				require '../vendor/PHPMailer/PHPMailerAutoload.php';
				
				//Create a new PHPMailer instance
				$mail = new \PHPMailer();
				//Tell PHPMailer to use SMTP
				$mail->IsSMTP();
				//Enable SMTP debugging
				// 0 = off (for production use)
				// 1 = client messages
				// 2 = client and server messages
				$mail->SMTPDebug  = 0;
				//Ask for HTML-friendly debug output
				$mail->Debugoutput = 'html';
				//Set the hostname of the mail server
				$mail->Host       = 'smtp.gmail.com';
				//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
				$mail->Port       = 465;
				//Set the encryption system to use - ssl (deprecated) or tls
				$mail->SMTPSecure = 'ssl';
				//Whether to use SMTP authentication
				$mail->SMTPAuth   = true;
				//Username to use for SMTP authentication - use full email address for gmail
				$mail->Username   = 'tvseriemanager75@gmail.com';
				//Password to use for SMTP authentication
				$mail->Password   = 'Webforce3';
				//Set who the message is to be sent from
				$mail->SetFrom('tvseriemanager75@gmail.com', 'CAMS Squad');
				//Set who the message is to be sent to
				$mail->AddAddress('tvseriemanager75@gmail.com', 'John Doe');
				//Set the subject line
				//$mail->Subject = 'PHPMailer GMail SMTP test';
				//Read an HTML message body from an external file, convert referenced images to embedded, convert HTML into a basic plain-text alternative body
				$mail->Subject = 'Test PhPMailer';

				//envoyer un lien par mail
				$token = \W\Security\StringUtils::randomString(32);

				$userManager->update([
					'token' => $token
				], $user['id']);

				$url = $this->generateUrl("new_password", [
					'token' => $token,
					'id' => $user['id']
					], true);
				$mail->MsgHTML("message" . "<a href='$url'>" . $url . "</a>");

				//envoie le message et vérifie s'il y a une erreur
				if(!$mail->Send()) {
					echo 'Mailer Error: ' . $mail->ErrorInfo;
				} else {
					
				}
			}

		}

		else {
			$error = "Please put a email.";
		}

		$this->show("user/password", [
			"error"=> $error,
			"email" => $email
		]);
		
	}


	/**
	 *  page new password
	 */

	public function newPassword($token, $id)
	{
		
		$error = "";

		if ($_POST){

			$userManager = new \Manager\UserManager();

			$user = $userManager->find($id);

			if ($user['token'] == $token){

			}
			else {
				echo "Piratage";
			}

			// changement de password
			$password = $_POST['password'];
			$password_bis = $_POST['password_bis'];

			$isValid = true;

			if (empty($password) || empty($password_bis)) {
				$isValid = false;
				$error = "Fill the field please !";
			
			} else if (strlen($password) < 5){
				$isValid = false;
				$error = "Password too short !";

			} else {
				$userManager->update([
					'password' => password_hash($password, PASSWORD_DEFAULT)
				], $user['id']);

				$this->redirectToRoute("profile");

			}

		} 
		else {
			
		}

		$this->show("user/new_password", ["error"=>$error]);
	}


}