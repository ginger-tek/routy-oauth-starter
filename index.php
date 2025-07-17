<?php

require_once 'vendor/autoload.php';

use GingerTek\Routy;
use App\Middlewares\AuthMiddleware;
use App\Controllers\ApiController;

\App\Services\Env::load(__DIR__ . '/.env');

$app = new Routy;
$app->use(AuthMiddleware::index(...));
$app->group('/api', ApiController::index(...));
$app->serveStatic('/', 'public');
$app->end(404);