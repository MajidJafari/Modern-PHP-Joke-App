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
		
		// If the page is the password-protected
		if(isset($routes[$this->route]['login'])
			&&($routes[$this->route]['login'])
		   // and the user is not logged in
		    && (!$this->routes->getAuthentication()->isLoggedIn())) {
			
				// Display the login form.
				$this->route = 'login';
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