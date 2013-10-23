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
                $isValid = $this->storeUser($data);
                // redirect somewhere
                //return $app->redirect($app['url_generator']->generate('register/firstadmin'));
            }
        }

        // display the form
        return $app['twig']->render('Pages/Register/firstadmin.twig', array('registerFirstadmin' => $form->createView()));
    }

    public function storeUser($data) {
        extract($data);
        $password_hash = password_hash($password, PASSWORD_DEFAULT, array('cost' => 15));
        $user = array(
          'username'      => $username,
          'email'         => $email,
          'password_hash' => $password_hash,
        );

        $db = new DB\LiMongo('users');
        try {
            $db->insert($user);
            $db->ensureIndex(
              array('username' => 1, 'email' => 1 ),
              array('unique' => true)
            );
        } catch (\MongoCursorException $e) {
            var_dump($e);
        }
    }
}