<?php
/**
 * Created by PhpStorm.
 * User: Majid
 * Date: 3/17/2018
 * Time: 8:40 AM
 */

namespace Amghezi;

class Authentication {
	
	private $users;
	private $usernameColumn;
	private $passwordColumn;
	
	public function __construct(DatabaseTable $users, $usernameColumn, $passwordColumn) {
		session_start();
		$this->users=$users;
		$this->usernameColumn=$usernameColumn;
		$this->passwordColumn=$passwordColumn;
	}
	
	/**
	 * This function checks if a user in database match anyone with username and password provided or not,
	 * If so, it will set the session's variables for future check.
	 * @param $username: The username provided by the user
	 * @param $password: The password provided by the user
	 *
	 * @return bool: True, if the user exists and thus the session's variables has been set.
	 */
	public function canLogin($username, $password) {
		// Fetch the user info using it's username
		$user = $this->users->find($this->usernameColumn,strtolower($username))[0];
		
		// Check if the user exists and the password is correct
		if(!empty($user) && password_verify($password, $user[$this->passwordColumn])) {
			
			// Regenerate session id as the countermeasure for session fixation attack.
			session_regenerate_id();
			
			$_SESSION['username'] = $username;
			$_SESSION['password'] = $user[$this->passwordColumn];
			return true;
		}
		else {
			return false;
		}
	}
	
	/**
	 * This function checks if the user is logged in or not, by checking the active session's variables.
	 * @return bool: True, if the user's session's password matches the one stored in the database for him/her.
	 */
	public function isLoggedIn() {
		if(empty($_SESSION['username'])) {
			return false;
		}
		
		$user = $this->users->find($this->usernameColumn, strtolower($_SESSION['username']))[0];
		
		if(!empty($user) && ($user[$this->passwordColumn] === $_SESSION['password'])) {
			return true;
		}
		else {
			return false;
		}
		
	}
}