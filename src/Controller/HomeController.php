<?php
namespace AppMain\Controller;

class HomeController extends \SlimDash\Core\SlimDashController {
	public function getHome() {
		$this->render('@theme/home');
	}
}