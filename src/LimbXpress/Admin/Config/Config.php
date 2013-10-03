<?php
namespace LimbXpress\Admin\Config;

use Silex\Provider;
use Silex\Application;
use Silex\Provider\FormServiceProvider;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Translation\Loader\YamlFileLoader;

class Config
{
    static public function init(Application $app)
    {
        /* Validator Service Provider */
        $app->register(new Silex\Provider\ValidatorServiceProvider());
        
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

        /* Form Service Provider */
        $app->register(new FormServiceProvider(), array(
          'form.secret' => 'f90fc0cf8e2a872c30eba8101e3de18d',
        ));

        /* URL Generator Provider */
        $app->register(new \Silex\Provider\UrlGeneratorServiceProvider());
    }
}