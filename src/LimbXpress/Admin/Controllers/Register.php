<?php

namespace LimbXpress\Admin\Controllers;

use Silex\Application;
use Symfony\Component\Validator\Constraints as Assert;
use LimbXpress\Config\Database as DB;

class Register
{
    // Connects the routes in Silex
    static public function addRoutes($routing)
    {
        $routing->match('register/firstadmin/', array(new self(), 'registerFirstadmin'))->bind('register/firstadmin');
    }

    public function registerFirstadmin(Application $app)
    {
        $request = $app['request'];

        $form = $app['form.factory']->createBuilder('form')
            ->add('username', 'text', array(
                'constraints' => new Assert\NotBlank))
            ->add('email', 'email', array(
                'constraints' => new Assert\NotBlank))
            ->add('password', 'password', array(
                'constraints' => new Assert\NotBlank))
            ->getForm();

        if ('POST' == $request->getMethod()) {
            $form->bind($request);

            if ($form->isValid()) {
                $data = $form->getData();
                $this->storeUser($data);
                // redirect somewhere
                //return $app->redirect($app['url_generator']->generate('register/firstadmin'));
            }
        }

        // display the form
        return $app['twig']->render('Pages/Register/firstadmin.twig', array('registerFirstadmin' => $form->createView()));
    }

    public function storeUser($data) {
        extract($data);
        $password_salt = openssl_random_pseudo_bytes(32);
        $password_hash = sha1($password . $password_salt);
        $user = array(
          'username'      => $username,
          'email'         => $email,
          'password_hash' => $password_hash,
          'password_salt' => new \MongoBinData($password_salt),
        );

        $db = new DB\LiMongo('users');
        $db->insert($user);
        // Create unique indexes on email and username
        $db->ensureIndex(
            array('username' => 1, 'email' => 1 ),
            array("unique" => true)
        );
    }
}