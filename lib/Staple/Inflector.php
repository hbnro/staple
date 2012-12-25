<?php

namespace Staple;

class Inflector
{

  public static $plural = array(
                  '/(quiz)$/i' => '\\1zes',
                  '/^(ox)$/i' => '\\1en',
                  '/([m|l])ouse$/i' => '\\1ice',
                  '/(matr|vert|ind)ix|ex$/i' => '\\1ices',
                  '/(x|ch|ss|sh)$/i' => '\\1es',
                  '/([^aeiouy]|qu)y$/i' => '\\1ies',
                  '/(hive)$/i' => '\\1s',
                  '/(?:([^f])fe|([lr])f)$/i' => '\\1\\1ves',
                  '/(shea|lea|loa|thie)f$/i' => '\\1ves',
                  '/sis$/i' => 'ses',
                  '/([ti])um$/i' => '\\1a',
                  '/(tomat|potat|ech|her|vet)o$/i'=> '\\1oes',
                  '/(bu)s$/i' => '\\1ses',
                  '/(alias)$/i' => '\\1es',
                  '/(octop)us$/i' => '\\1i',
                  '/(ax|test)is$/i' => '\\1es',
                  '/(us)$/i' => '\\1es',
                  '/s$/i' => 's',
                  '/$/' => 's',
                );

  public static $singular = array(
                  '/(quiz)zes$/i' => '\\1',
                  '/(matr)ices$/i' => '\\1ix',
                  '/(vert|ind)ices$/i' => '\\1ex',
                  '/^(ox)en$/i' => '\\1',
                  '/(alias)es$/i' => '\\1',
                  '/(octop|vir)i$/i' => '\\1us',
                  '/(cris|ax|test)es$/i' => '\\1is',
                  '/(shoe)s$/i' => '\\1',
                  '/(o)es$/i' => '\\1',
                  '/(bus)es$/i' => '\\1',
                  '/([m|l])ice$/i' => '\\1ouse',
                  '/(x|ch|ss|sh)es$/i' => '\\1',
                  '/(m)ovies$/i' => '\\1ovie',
                  '/(s)eries$/i' => '\\1eries',
                  '/([^aeiouy]|qu)ies$/i' => '\\1y',
                  '/([lr])ves$/i' => '\\1f',
                  '/(tive)s$/i' => '\\1',
                  '/(hive)s$/i' => '\\1',
                  '/(li|wi|kni)ves$/i' => '\\1fe',
                  '/(shea|loa|lea|thie)ves$/i'=> '\\1f',
                  '/(^analy)ses$/i' => '\\1sis',
                  '/((a)naly|(b)a|(d)iagno|(p)arenthe|(p)rogno|(s)ynop|(t)he)ses$/i' => '\\1\\1sis',
                  '/([ti])a$/i' => '\\1um',
                  '/(n)ews$/i' => '\\1ews',
                  '/(h|bl)ouses$/i' => '\\1ouse',
                  '/(corpse)s$/i' => '\\1',
                  '/(us)es$/i' => '\\1',
                  '/s$/i' => '',
                );

  public static $irregular = array(
                  'move' => 'moves',
                  'foot' => 'feet',
                  'goose' => 'geese',
                  'sex' => 'sexes',
                  'child' => 'children',
                  'man' => 'men',
                  'tooth' => 'teeth',
                  'person' => 'people',
                );

  public static $uncountable = array(
                  'sheep',
                  'fish',
                  'deer',
                  'series',
                  'species',
                  'money',
                  'rice',
                  'information',
                  'equipment',
                );


  public static function singularize($test)
  {
    return static::apply($test, static::$singular);
  }

  public static function pluralize($test)
  {
    return static::apply($test, static::$plural);
  }

  public static function apply($test, array $set = array())
  {
    // TODO: cache this?
    if (in_array($test, static::$uncountable)) {
      return $test;
    }

    foreach (static::$irregular as $key => $one) {
      if ($key === $test) {
        return str_replace($key, $one, $test);
      }
    }

    foreach ($set as $key => $one) {
      if (preg_match($key, $test)) {
        return preg_replace($key, $one, $test);
      }
    }

    return $test;
  }

}
