<?php
/**
 * Created by PhpStorm.
 * User: Majid
 * Date: 3/10/2018
 * Time: 10:48 PM
 */

namespace Ijdb;

class IjdbRoutes implements \Amghezi\Routes {
	public function getRoutes() {
		
		$jokesTable = new \Amghezi\DatabaseTable('joke');
		$authorsTable = new \Amghezi\DatabaseTable('author');
		
		$jokeController = new \Ijdb\Controllers\Joke($jokesTable, $authorsTable);
		$authorController = new \Ijdb\Controllers\Register($authorsTable);
		
		$routes = [
			'author/register' => [
				'GET' => [
					'controller' => $authorController,
					'action' => 'registrationForm'
				],
				'POST' => [
					'controller' => $authorController,
					'action' => 'registerUser'
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
			],
			'joke/delete' => [
				'POST' => [
					'controller' => $jokeController,
					'action' => 'delete'
				]
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
}