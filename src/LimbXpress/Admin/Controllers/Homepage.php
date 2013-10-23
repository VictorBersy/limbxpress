<?php

namespace LimbXpress\Admin\Controllers;

use Silex\Application;
use LimbXpress\Config\Database as DB;

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
        return $app['twig']->render('Pages/Homepage/homepage.twig', array('userExists' => $this->userExists()));
    }

    public function userExists() {
        $db = new DB\LiMongo('users');
        return $db->count() > 0;
    }
}