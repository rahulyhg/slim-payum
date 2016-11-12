<?php
namespace AppMain\Controller;

class HomeController extends \SlimDash\Core\SlimDashController
{
    /**
     * render the dummy home page on get
     */
    public function getHome()
    {
        $this->render('@theme/home');
    }
}
