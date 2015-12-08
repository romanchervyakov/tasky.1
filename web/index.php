<?php

define('ENV', 'TEST');

use Model\Task;

$app = require_once __DIR__.'/../config/bootstrap.php';

$app->get('/', function() use ($app) {
    return $app->redirect($app['url_generator']->generate('account'));
});

$app->get('/account/{type}', function($type) use ($app) {
    if (null === $app['session']->get('session_login')) {
        return $app['twig']->render('auth/form.twig', [
            'errorMessage' => 'You should authenticate first',
        ]);
    } else {
        $task = new Task($app['pdo']);

        $tasksList = $task->getTasks($type);

        return $app['twig']->render('account/account.twig', [
            'login' => $app['session']->get('session_login'),
            'tasksList' => $tasksList,
            'type' => ucfirst($type),
        ]);
    }
})->bind('account')->value('type', 'queue');

$app->get('/login', function() use ($app) {
    $app['session']->set('session_login', null);

    return $app['twig']->render('auth/form.twig', [
        'errorMessage' => null,
    ]);
})->bind('login');

$app->post('/task/save', function() use ($app) {
    if (null === $app['session']->get('session_login')) {
        return $app['twig']->render('auth/form.twig', [
            'errorMessage' => 'You should authenticate first',
        ]);
    }

    $title = $app['request']->get('title');
    $task = new Task($app['pdo']);
    $task->save($title);
    return $app->redirect($app['url_generator']->generate('account'));
})->bind('create');

$app->get('/task/done/{id}', function($id) use ($app) {
    if (null === $app['session']->get('session_login')) {
        return $app['twig']->render('auth/form.twig', [
            'errorMessage' => 'You should authenticate first',
        ]);
    }

    $task = new Task($app['pdo']);
    $task->done($id);
    return $app->redirect($app['url_generator']->generate('account'));
})->bind('done');

$app->get('/task/delete/{id}', function($id) use ($app) {
    if (null === $app['session']->get('session_login')) {
        return $app['twig']->render('auth/form.twig', [
            'errorMessage' => 'You should authenticate first',
        ]);
    }

    $task = new Task($app['pdo']);
    $task->delete($id);
    return $app->redirect($app['url_generator']->generate('account'));
})->bind('delete');

$app->get('/task/remove/{id}', function($id) use ($app) {
    if (null === $app['session']->get('session_login')) {
        return $app['twig']->render('auth/form.twig', [
            'errorMessage' => 'You should authenticate first',
        ]);
    }

    $task = new Task($app['pdo']);
    $task->remove($id);
    return $app->redirect($app['url_generator']->generate('account'));
});

$app->post('/auth', function() use ($app) {

    $login = $app['request']->get('login');
    $pass = $app['request']->get('pass');

    $auth = new \Model\Auth($app['pdo']);

    if ($auth->isUserFound($login, $pass)) {
        $app['session']->set('session_login', $login);

        return $app->redirect($app['url_generator']->generate('account'));
    } else {
        return $app['twig']->render('auth/form.twig', [
            'errorMessage' => 'Wrong login or password!'
        ]);
    }
});

// party should go on :)
$app->run();