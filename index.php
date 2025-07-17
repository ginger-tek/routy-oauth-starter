<?php

require_once 'vendor/autoload.php';

\App\Services\Env::load(__DIR__ . '/.env');

$app = new \GingerTek\Routy;
$app->use(\App\Middlewares\AuthMiddleware::index(...));
$app->group('/api', \App\Controllers\ApiController::index(...));
$app->serveStatic('/', 'public');
$app->end(404);