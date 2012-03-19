<?php
/*
 * This file is part of the BaseSilex Application
 *
 * (c) Pascal Filipovicz <pascal.filipovicz@frozenk.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

$app = new Silex\Application();

// Registering Services

// Monolog
$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile'       => __DIR__.'/../logs/development.log',
    'monolog.class_path'    => __VENDOR__.'/monolog/src',
));

// Twig
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path'         => __DIR__.'/../views',
    'twig.class_path'   => __VENDOR__ . '/twig/twig/lib',
    'twig.options'      => array(),
));

// Cache
$app->register(new Silex\Provider\HttpCacheServiceProvider(), array(
   'http_cache.cache_dir' => __DIR__.'/../cache/',
));

// Sessions
$app->register(new Silex\Provider\SessionServiceProvider());

// Doctrine Common & DBAL
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'    => 'pdo_mysql',
        'dbname'    => __DBNAME__,
        'host'      => 'localhost',
        'user'      => 'LOGIN',
        'password'  => 'PASSWORD'
    ),
    'db.dbal.class_path'    => __VENDOR__ . '/doctrine-dbal/lib',
    'db.common.class_path'  => __VENDOR__ . '/doctrine-common/lib',
));

// Validator
$app->register(new Silex\Provider\ValidatorServiceProvider(), array(
    'validator.class_path'  => __VENDOR__ . '/symfony/validator',
));

// Form
$app->register(new Silex\Provider\FormServiceProvider(), array(
    'form.class_path' => __VENDOR__ . '/symfony/form',
));

// Bridge
$app->register(new Silex\Provider\SymfonyBridgesServiceProvider(), array(
    'symfony_bridges.class_path'  => __VENDOR__ . '/symfony/twig-bridge',
));

// Before
$app->before(function () use ($app) {
    $app['session']->start();

    // Register Translation component
    $app->register(new Silex\Provider\TranslationServiceProvider(), array(
        'locale'                  => 'en',
        'locale_fallback'         => 'en',
        'translation.class_path'  => __VENDOR__ .'/symfony/translation',
    ));

    $app['translator.messages'] = array(
        'en' => __RESOURCES__ . '/locales/en.yml',
        'fr' => __RESOURCES__ . '/locales/fr.yml',
    );

    // YAML loader initialization
    $app['translator.loader'] = new Symfony\Component\Translation\Loader\YamlFileLoader();

    // Twig translation extension initialisation (allow to use tag {% trans %} and filter | trans in templates)
    $app['twig']->addExtension(new Symfony\Bridge\Twig\Extension\TranslationExtension($app['translator']));

    // Layout
    $app['twig']->addGlobal('layout', $app['twig']->loadTemplate('layout.twig'));
});

// Mount
$app->mount('/', new BaseSilex\BaseSilexControllerProvider());

// Errors
$app->error(function (\Exception $e, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    switch ($code) {
        case 404:
            $message = 'The requested page could not be found.';
            break;
        default:
            $message = 'We are sorry, but something went terribly wrong.';
    }

    return new Response($message, $code);
});

// Finish
return $app;
