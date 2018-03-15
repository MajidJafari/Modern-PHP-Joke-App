<?php
/**
 * Created by PhpStorm.
 * User: Majid
 * Date: 3/15/2018
 * Time: 10:40 AM
 */

namespace Amghezi;

class Controller {
	protected function return($title, $template, $variables = null){
		return [
			'title' => $title,
			'template' => $template,
			'variables' => $variables
		];
	}
}