<?php

namespace LimbXpress\Admin;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Response;

class Admin implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        // load configuration specific to Admin
        Config\Config::init($app);

        // creates a new controller based on the default route
        $routing = $app['controllers_factory'];

        /* Set corresponding endpoints on the controller classes */
        Controllers\Homepage::addRoutes($routing);
        Controllers\Register::addRoutes($routing);

        return $routing;
    }
}