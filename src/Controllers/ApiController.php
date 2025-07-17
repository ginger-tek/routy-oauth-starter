<?php

namespace App\Controllers;

use GingerTek\Routy;

class ApiController
{
  public static function index(Routy $app)
  {
    $app->get('/users', function () use ($app) {
      // Example response
      $app->sendJson([
        'users' => [
          ['id' => 1, 'name' => 'John Doe'],
          ['id' => 2, 'name' => 'Jane Smith']
        ]
      ]);
    });
  }
}