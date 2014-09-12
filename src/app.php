<?php

use Igorw\Silex\ConfigServiceProvider;
use Silex\Application;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\SwiftmailerServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\Validator\Constraints as Assert;

$app = new Application();
$app->register(new ConfigServiceProvider(__DIR__."/../config/parameters.yml"));
$app->register(new FormServiceProvider());
$app->register(new ServiceControllerServiceProvider());
$app->register(new SwiftmailerServiceProvider(), array(
    'swiftmailer.options' => $app['swiftmailer.options'],
    'swiftmailer.class_path' => __DIR__.'/../vendor/swiftmailer/lib/classes'
));
$app->register(new TranslationServiceProvider(), array(
    'locale_fallbacks' => array($app['locale']),
));
$app->register(new TwigServiceProvider());
$app->register(new UrlGeneratorServiceProvider());
$app->register(new ValidatorServiceProvider());

$app['twig'] = $app->share($app->extend('twig', function ($twig, $app) {
    return $twig;
}));

$app['translator'] = $app->share($app->extend('translator', function($translator, $app) {
    $translator->addLoader('yaml', new YamlFileLoader());

    $translator->addResource('yaml', __DIR__.'/../resources/translations/es.yml', 'es');

    return $translator;
}));

$app['form.contact'] = function ($app) {
    $form = $app['form.factory']
        ->createBuilder('form')
            ->add('name', 'text', array(
                'required' => true,
                'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 5)))
            ))
            ->add('email', 'text', array(
                'required' => true,
                'constraints' => array(new Assert\Email(), new Assert\NotBlank())
            ))
            ->add('message', 'textarea', array(
                'required' => true,
                'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 10)))
            ))
            ->add('submit', 'submit', array(
                'label' => 'contact_submit'
            ))
        ->getForm();

    return $form;
};

return $app;
