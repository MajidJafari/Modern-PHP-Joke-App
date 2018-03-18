<?php
/**
 * Created by PhpStorm.
 * User: Majid
 * Date: 3/10/2018
 * Time: 10:48 PM
 */

namespace Ijdb;

use Amghezi\Controller;
use \Amghezi\DatabaseTable;
use \Amghezi\Routes;
use \Amghezi\Authentication;

class IjdbRoutes implements Routes {
	
	private $jokesTable;
	private $authorsTable;
	private $authentication;
	
	public function __construct() {
		$this->jokesTable = new DatabaseTable('joke');
		$this->authorsTable = new DatabaseTable('author');
		$this->authentication = new Authentication($this->authorsTable, 'email', 'password');
	}
	
	public function getRoutes():array {
		
		$loginController = new Controllers\Login($this->authentication);
		$authorController = new Controllers\Register($this->authorsTable);
		$jokeController = new Controllers\Joke($this->jokesTable, $this->authorsTable);
		
		$routes = [
			'login' => [
				'GET' => [
					'controller' => $loginController,
					'action' => 'getLoginForm'
				],
				'POST' => [
					'controller' => $loginController,
					'action' => 'processLogin'
				],
			],
			'logout' => [
				'GET' => [
					'controller' => $loginController,
					'action' => 'logout'
				]
			],
			'author/register' => [
				'GET' => [
					'controller' => $authorController,
					'action' => 'getRegistrationForm'
				],
				'POST' => [
					'controller' => $authorController,
					'action' => 'processRegister'
				]
			],
			'author/success' => [
				'GET' => [
					'controller' => $authorController,
					'action' => 'success'
				]
			],
			'joke/save' => [
				'POST' => [
					'controller' => $jokeController,
					'action' => 'save'
				],
				'GET' => [
					'controller' => $jokeController,
					'action' => 'addOrEdit'
				],
				'login' => true
			],
			'joke/delete' => [
				'POST' => [
					'controller' => $jokeController,
					'action' => 'delete'
				],
				'login' => true,
				'noForm' => true
			],
			'joke/list' => [
				'GET' => [
					'controller' => $jokeController,
					'action' => 'list'
				]
			],
			// Default route
			'' => [
				'GET'=> [
					'controller' => $jokeController,
					'action' => 'home'
				]
			]
		];
		
		return $routes;
	}
	
	public function getAuthentication():Authentication {
		return $this->authentication;
	}
	
	public function getLoginRoute():string {
		return 'login';
	}
}