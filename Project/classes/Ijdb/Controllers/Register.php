<?php
/**
 * Created by PhpStorm.
 * User: Majid
 * Date: 3/9/2018
 * Time: 8:47 PM
 */

namespace Ijdb\Controllers;

class Register extends \Amghezi\Controller {
	private $authorsTable;
	
	public function __construct($authorsTable) {
		$this->authorsTable = $authorsTable;
	}
	
	public function registrationForm() {
		return $this->return('Register an account', 'register');
	}
	
	public function registerUser() {
		
		$author = $_POST['author'];
		$valid = true; // By default the form submission is valid
		$errors = [];
		
		//Form validation
		if(empty($author['name'])) {
			$valid = false;
			$errors[] = 'Name can\'be blank.';
		}
		if(empty($author['email'])) {
			$valid = false;
			$errors[] = 'Email can\'t be blank';
		}
		if(empty($author['password'])) {
			$valid= false;
			$errors[] = 'Password can\'t be blank';
		}
		
		if($valid) {
			$this->authorsTable->save($author);
			
			header('Location: /author/success');
		} else {
			$variables['error'] = $errors;
			$variables['author'] = $author;
			
			return $this->return('Register an account', 'register', $variables??[]);
		}
	}
	
	public function success() {
		return $this->return('Registration Successful', 'registerSuccess');
	}
}