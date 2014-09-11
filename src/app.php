<?php

use Igorw\Silex\ConfigServiceProvider;
use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\SwiftmailerServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Symfony\Component\Translation\Loader\YamlFileLoader;

$app = new Application();
$app->register(new UrlGeneratorServiceProvider());
$app->register(new ValidatorServiceProvider());
$app->register(new ServiceControllerServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new ConfigServiceProvider(__DIR__."/../config/parameters.yml"));
$app->register(new TranslationServiceProvider(), array(
    'locale_fallbacks' => array($app['locale']),
));
$app->register(new SwiftmailerServiceProvider(), array(
    'swiftmailer.options' => $app['swiftmailer.options'],
    'swiftmailer.class_path' => __DIR__.'/../vendor/swiftmailer/lib/classes'
));

$app['twig'] = $app->share($app->extend('twig', function ($twig, $app) {
    return $twig;
}));

$app['translator'] = $app->share($app->extend('translator', function($translator, $app) {
    $translator->addLoader('yaml', new YamlFileLoader());

    $translator->addResource('yaml', __DIR__.'/../resources/translations/es.yml', 'es');

    return $translator;
}));

return $app;
