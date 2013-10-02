<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;

$app->mount('/admin', new LimbXpress\Admin\Admin());

$app->run();