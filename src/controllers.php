<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//Request::setTrustedProxies(array('127.0.0.1'));

$app->get('/', function () use ($app) {
    $contactForm = $app['form.contact'];

    return $app['twig']->render(
        'index.html.twig',
        array(
            'contactForm' => $contactForm->createView(),
            'links' => array(
                'github' => 'https://github.com/arkaitzgarro',
                'twitter' => 'https://twitter.com/arkaitzgarro',
                'linkedin' => 'https://es.linkedin.com/in/arkaitzgarro',
                'instagram' => 'http://instagram.com/arkaitzgarro',
            )
        )
    );
})
->bind('homepage')
;

$app->post('/contact', function () use ($app) {
    $request = $app['request'];
    $contactForm = $app['form.contact'];

    $contactForm->bind($request);
    if ($contactForm->isValid()) {
        $data = $contactForm->getData();

        $message = \Swift_Message::newInstance()
            ->setSubject('[WEBSITE] Contact')
            ->setFrom(array($app['contact']['from']))
            ->setTo(array($app['contact']['to']))
            ->setReplyTo(array($data['email']))
            ->setBody($app['twig']->render(
                'email/contact.html.twig',
                array(
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'message' => $data['message']
                    )
                ),
                'text/html'
            );

        $app['mailer']->send($message);

        return $app->json(array('ok' => true));
    }

    return $app->json(array('ko' => true));
})
->bind('contact')
;

$app->error(function (\Exception $e, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/'.$code.'.html',
        'errors/'.substr($code, 0, 2).'x.html',
        'errors/'.substr($code, 0, 1).'xx.html',
        'errors/default.html',
    );

    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});
