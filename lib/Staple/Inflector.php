<?php

namespace Staple;

class Inflector
{

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
    $value = preg_replace('/\W/', '_', preg_replace('/[A-Z](?=\w)/', '_\\0', $value));
    $value = preg_replace_callback('/(^|\W)([A-Z])/', function ($match) {
        "$match[1]_" . strtolower($match[2]);
      }, $value);

    $value = trim(strtr($value, ' ', '_'), '_');
    $value = strtolower($value);

    return $value;
  }

  public static function camelcase($value, $ucfirst = FALSE, $glue = '')
  {
    $value = preg_replace('/[^a-z0-9]|\s+/i', ' ', $value);
    $value = preg_replace_callback('/\s([a-z])/i', function ($match)
      use ($glue) {
        return $glue . ucfirst($match[1]);
      }, $value);


    $value = $ucfirst ? ucfirst($value) : $value;
    $value = str_replace(' ', '', trim($value));

    return $value;
  }

}
