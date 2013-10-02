<?php

namespace LimbXpress\Admin\Controllers;

use Silex\Application;

class Homepage
{
    // Connects the routes in Silex
    static public function addRoutes($routing)
    {
        $routing->get('/', array(new self(), 'homepage'))->bind('homepage');
    }

    public function homepage(Application $app)
    {
        // render the homepage
        return $app['twig']->render('pages/home/home.twig');
    }
}