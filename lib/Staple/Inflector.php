<?php

namespace Staple;

class Inflector
{

  private static $under_repl = array(
                    '/(^|\W)([A-Z])/e' => '"\\1_".strtolower("\\2");',
                    '/[A-Z](?=\w)/' => '_\\0',
                  );

  private static $param_repl = array(
                    '/[^a-z0-9]|\s+/ie' => '$glue;',
                    '/\s([a-z])/ie' => '$glue.ucfirst("\\1");',
                  );



  public static function parameterize($value)
  {
    return strtolower(trim(static::camelcase($value, FALSE, '-'), '-'));
  }

  public static function classify($value)
  {
    return static::camelcase($value, TRUE, '\\');
  }

  public static function underscore($value)
  {
    $value = preg_replace(array_keys(static::$under_repl), static::$under_repl, $value);
    $value = trim(strtr($value, ' ', '_'), '_');
    $value = strtolower($value);

    return $value;
  }

  public static function camelcase($value, $ucfirst = FALSE, $glue = '')
  {
    $value = preg_replace(array_keys(static::$param_repl), static::$param_repl, static::underscore($value));

    if ($ucfirst) {
      $value = ucfirst($value);
    }
    return $value;
  }

}
