<?php
/**
 * Created by PhpStorm.
 * User: Majid
 * Date: 3/10/2018
 * Time: 8:14 AM
 */

namespace Amghezi;

class EntryPoint {
	private $route;
	private $method;
	private $routes;
	
	public function __construct(string $route,string $method,\Amghezi\Routes $routes) {
		$this->route = $route;
		$this->method = $method;
		$this->routes = $routes;
		$this->checkUrl();
	}
	
	/**
	 * Since we don't want to list the other versions of urls to be listed as separate pages by search engines,
	 * We should make them as permanent redirect. This function do this for us.
	 */
	private function checkUrl() {
		if($this->route !== strtolower($this->route)) {
			http_response_code(301);
			header('location: ' .strtolower($this->route));
		}
	}
	
	private function loadTemplate($template, $variables) {
		// Set extra required variables for each template
		if($variables) {
			extract($variables);
		}
		
		ob_start();
		include __DIR__ . '/../../templates/' . $template . '.html.php';
		return ob_get_clean();
	}
	
	public function run() {
		$routes = $this->routes->getRoutes();
		$isLoggedIn = $this->routes->getAuthentication()->isLoggedIn();
		
		// If the page is the password-protected
		if(isset($routes[$this->route]['login'])
			&&($routes[$this->route]['login'])
		   // and the user is not logged in
		    && !$isLoggedIn){
				/* We should save post info if the user clicked on a route without the form,
				 * because when login form is submitted,
				 * the post info will be overwritten.
				 *
				 * We shouldn't follow this instruction for the route with form,
				 * because their corresponding forms will be displayed after the login form is submitted,
				 * thus the post info will be overwritten correctly.
				 */
				if(isset($routes[$this->route]['noForm'])
				   && ($routes[$this->route]['noForm'])
				   && (!isset($_SESSION['post']))) {
						$_SESSION['post'] = $_POST;
				}
				
				// Display the login form.
				$this->route = $this->routes->getLoginRoute();
		}
		
		 // Display the page content.
		$controller = $routes[$this->route][$this->method]['controller'];
		$action = $routes[$this->route][$this->method]['action'];
		
		$page = $controller->$action();
		extract($page);
		
		$output = $this->loadTemplate($template??'home', $variables??[]);
		
		include __DIR__ . '/../../templates/layout.html.php';
	}
}