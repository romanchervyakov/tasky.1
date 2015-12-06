<?php

require_once __DIR__.'/../vendor/autoload.php';

require_once __DIR__.'/../config/database_test.php';

$app = new Silex\Application();

$app['debug'] = true;

// pdo mysql
$app['pdo'] = $app->share(function() {
    $dsn = 'mysql:host='.HOST.';dbname='.DATABASE.';';
    $opt = [
        PDO::ATTR_ERRMODE              => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE   => PDO::FETCH_ASSOC,
    ];

    return new \PDO($dsn, USER, PASS, $opt);
});

// services
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());

// controllers
$app->get('/account', function() {
    return 'Auth only';
})->bind('account');

$app->get('/login', function() use ($app) {
    return $app['twig']->render('auth/form.twig');
});

// party should go on
$app->run();