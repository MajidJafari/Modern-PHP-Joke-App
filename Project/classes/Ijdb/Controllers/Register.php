<?php
/**
 * Created by PhpStorm.
 * User: Majid
 * Date: 3/9/2018
 * Time: 8:47 PM
 */

namespace Ijdb\Controllers;

class Register {
	private $authorsTable;
	
	public function __construct($authorsTable) {
		$this->authorsTable = $authorsTable;
	}
}