<?php

namespace LimbXpress\Admin\Controllers;

use Silex\Application;

class Register
{
    // Connects the routes in Silex
    static public function addRoutes($routing)
    {
        $routing->get('/', array(new self(), 'register'))->bind('register');
    }

    public function register(Application $app)
    {
        // render the register page
        return $app['twig']->render('pages/register/register.twig');
    }
}