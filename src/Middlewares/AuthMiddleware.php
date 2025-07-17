<?php

namespace App\Middlewares;

use GingerTek\Routy;
use App\Services\AuthService;
use Vudev\JsonWebToken\JWT;

class AuthMiddleware
{
  public static function index(Routy $app)
  {
    session_start(['read_and_close' => true]);
    $app->setCtx('authService', new AuthService());
    $app->post('/oauth', self::receiveOAuthResponse(...));
    $app->get('/logout', self::logout(...));
    $app->get('/', self::authenticate(...));
  }

  private static function authenticate(Routy $app)
  {
    if (!isset($_SESSION['user']) || $_SESSION['user']->exp < time() - 60)
      $app->redirect($app->getCtx('authService')->getLoginURL());
  }

  private static function logout(Routy $app)
  {
    if (!isset($_SESSION['user']))
      $app->end(401);
    session_start();
    session_destroy();
    $app->redirect($app->getCtx('authService')->getLogoutURL());
  }

  private static function receiveOAuthResponse(Routy $app)
  {
    $body = $app->getBody();
    if (!isset($app->query->code) && !$body)
      $app->end(401);
    if (isset($body->error))
      $app->end(400);
    session_start();
    $_SESSION['user'] = (object) (new JWT)->json($body->id_token)['payload'];
    session_write_close();
    $app->redirect('/');
  }
}