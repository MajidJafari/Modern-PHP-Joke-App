<?php
/**
 * Created by PhpStorm.
 * User: Majid
 * Date: 3/5/2018
 * Time: 2:04 PM
 */

namespace Ijdb\Controllers;

use \Amghezi\DatabaseTable;
use \Amghezi\Controller;

class Joke extends Controller {
	private $jokesTable;
	private $authorsTable;
	
	public function __construct(DatabaseTable $jokesTable , DatabaseTable $authorsTable) {
		$this -> jokesTable = $jokesTable;
		$this -> authorsTable = $authorsTable;
	}
	
	public function list() {
		$result = $this -> jokesTable -> findAll();
		$jokes = [];
		
		foreach ($result as $joke) {
			$author = $this -> authorsTable -> findById($joke['authorId']);
			
			$jokes[] = [
				'id' => $joke['id'],
				'jokeText' => $joke['jokeText'],
				'jokeDate' => $joke['jokeDate'],
				'name' => $author['name'],
				'email' => $author['email']
			];
		}
		
		$variables['jokes'] = $jokes;
		$variables['totalJokes'] = $this -> jokesTable -> total();
		
		return $this->return('Jokes', 'jokes', $variables);
	}
	
	public function home() {
		return $this->return('Internet Joke Database', 'home');
	}
	
	public function delete() {
		if(isset($_SESSION['post'])) {
			$_POST = $_SESSION['post'];
			$_SESSION['post'] = null;
			unset($_SESSION['post']);
		}
		$this->jokesTable->delete($_POST['id']);
		header('LOCATION: /joke/list');
	}
	
	public function addOrEdit() {
		// Add action
		$title = 'Add Joke';
		
		// Edit action
		if(isset($_GET['id'])) {
			$variables['joke'] = $this->jokesTable->findById($_GET['id']);
			$title = 'Edit joke';
		}
		
		return $this->return($title, 'addOrEditJoke', $variables??[]);
	}
	
	public function save() {
		$joke = $_POST['joke'];
		$author = $this->authorsTable->find('email', $_SESSION['username'])[0];
		
		// If the action is and edit,the author is set ,
		// Else, we should assign it to the logged-in user
		$joke['authorId'] = $this->jokesTable->findById($joke['id'])['authorId'] ?? $author['id'] ?? 7;
		
		// Do edit or insert action
		$this->jokesTable->save($joke);
		
		// In either case of the action, redirect the user
		header("LOCATION: /joke/list");
	}
}