<?php
/**
 * Created by PhpStorm.
 * User: Majid
 * Date: 3/17/2018
 * Time: 10:32 AM
 */

namespace Ijdb\Controllers;

use Amghezi\Controller;

class Login extends Controller {
	
	private $authentication;
	
	public function __construct($authentication) {
		$this->authentication = $authentication;
	}
	
	public function processLogin() {
		if(empty($_POST['username']) || empty($_POST['password'])) {
			$error = 'Please enter your email and password.';
		} elseif(!$this->authentication->canLogin($_POST['username'], $_POST['password'])) {
			$error = 'Your email or password is incorrect.';
		} else {
			echo  $_SERVER['REQUEST_URI']."\n";
			// We should set http_response_code to 307 to tell the browser we are sending a post request in delete route,
			// so we could use the saved post info, as the delete rout has no GET method controller nor the action.
			header("Location: {$_SERVER['REQUEST_URI']}", true, (!isset($_SESSION['post'])) ? 302 : 307 );
		}
		
		$variables['error'] = $error;
		return $this->getLoginForm($variables);
	}
	
	public function getLoginForm($variables = []) {
		// If no error is set, we should show the user it needs to login.
		if(!$variables) {
			$variables['error'] = 'You must be logged in to view this page.';
		}
		
		return $this->return('Log In', 'login', $variables);
	}
}