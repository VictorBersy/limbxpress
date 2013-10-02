<?php
namespace LimbXpress\Admin\Config;

use Silex\Application;
use Silex\Provider;
use Symfony\Component\Translation\Loader\YamlFileLoader;

class Config
{
    static public function init(Application $app)
    {
        /* Twig Service Provider */
        $app->register(new \Silex\Provider\TwigServiceProvider(), array(
          'twig.path' => __DIR__.'/../Views/',
        ));

        /* Session Service Provider */
        $app->register(new \Silex\Provider\SessionServiceProvider());

        /* Swiftmailer Service Provider */
        $app->register(new \Silex\Provider\SwiftmailerServiceProvider());

        /* Translation Service Config */
        $app->register(new \Silex\Provider\TranslationServiceProvider(), array(
          'locale'          => 'en_US',
          'locale_fallback' => 'en_US',
        ));
        /* Translation Service Provider */
        $app['translator'] = $app->share($app->extend('translator', function($translator, $app) {
          $translator->addLoader('yaml', new YamlFileLoader());
          $translator->addResource('yaml', __DIR__.'/../Locales/en_US.yml', 'en_US');
          $translator->addResource('yaml', __DIR__.'/../Locales/fr_FR.yml', 'fr_FR');
          return $translator;
        }));
    }
}