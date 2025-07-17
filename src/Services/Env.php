<?php

namespace App\Services;

class Env
{
  public static function load(string $file): void
  {
    if (file_exists($file))
      foreach (parse_ini_file($file) as $key => $value)
        putenv("$key=$value");
  }
}
