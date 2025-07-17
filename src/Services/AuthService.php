<?php

namespace App\Services;

class AuthService
{
  protected string $baseURL;
  protected string $hostNameURL;

  public function __construct()
  {
    $this->baseURL = 'https://login.microsoftonline.com/' . getenv('AUTH_TENANT') . '/oauth2/v2.0/';
    $this->hostNameURL = (preg_match('/localhost/', $_SERVER['HTTP_HOST']) ? 'http' : 'https') . '://' . $_SERVER['HTTP_HOST'];
  }

  public function getLoginURL()
  {
    return $this->baseURL . '/authorize?' . http_build_query([
      'client_id' => getenv('AUTH_CLIENT_ID'),
      'redirect_uri' => "{$this->hostNameURL}/oauth",
      'response_type' => 'code id_token',
      'response_mode' => 'form_post',
      'scope' => 'openid offline_access profile https://graph.microsoft.com/user.read',
      'state' => uniqid(),
      'nonce' => uniqid()
    ]);
  }

  public function getLogoutURL()
  {
    return $this->baseURL . '/logout?' . http_build_query([
      'client_id' => getenv('AUTH_CLIENT_ID'),
      'post_logout_redirect_uri' => $this->hostNameURL,
      'state' => uniqid(),
      'nonce' => uniqid(),
    ]);
  }
}
