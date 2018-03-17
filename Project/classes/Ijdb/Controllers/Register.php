<?php
/**
 * Created by PhpStorm.
 * User: Majid
 * Date: 3/9/2018
 * Time: 8:47 PM
 */

namespace Ijdb\Controllers;

use Amghezi\Controller;

class Register extends Controller {
	private $authorsTable;
	
	public function __construct($authorsTable) {
		$this->authorsTable = $authorsTable;
	}
	
	public function getRegistrationForm() {
		return $this->return('Register an account', 'register');
	}
	
	public function processRegister() {
		
		$author = $_POST['author'];
		// Save the lowercase version of the email user provided for doing correct email duplication check
		$author['email'] = strtolower($author['email']);
		
		$valid = true; // By default the data is valid
		$errors = [];
		
		//Form validation
		
		// Check for email submission
		if(empty($author['email'])) {
			$valid = false;
			$errors[] = 'Email can\'t be blank';
		} elseif (filter_var($author['email'], FILTER_VALIDATE_EMAIL) == false) {
			$valid = false;
			$errors[] = 'Email is invalid';
		// Check for email duplication
		} elseif (count($this->authorsTable->find('email', $author['email'])) >0) {
			$valid = false;
			$errors[] = 'Email is already registered.';
		}
		
		// Check for name submission
		if(empty($author['name'])) {
			$valid = false;
			$errors[] = 'Name can\'be blank.';
		}
		
		// Check for password submission
		if(empty($author['password'])) {
			$valid= false;
			$errors[] = 'Password can\'t be blank';
		}
		
		// If the data is valid, do the registration
		if($valid) {
			// Hash the password
			$author['password'] = password_hash($author['password'], PASSWORD_DEFAULT);
			$this->authorsTable->save($author);
			
			header('Location: /author/success');
		} else { // Else, display errors.
			$variables['errors'] = $errors;
			$variables['author'] = $author;
			return $this->return('Register an account', 'register', $variables??[]);
		}
	}
	
	public function success() {
		return $this->return('Registration Successful', 'registerSuccess');
	}
}