<?php

$autoload = require dirname(__DIR__).DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';

$data = array(
    'foo' => 'bar',
    'candy' => array('does', 'nothing\'s', 'baz', 'buzz'),
    'else' => 'baz',
  );

$rules = array(
    'foo' => array('required'),
    'candy.1' => array('required','="nothing\'s"'),
    'else' => array('=candy.2')
  );

Staple\Validation::setup($rules);

var_dump(Staple\Validation::execute($data));

var_dump(Staple\Validation::errors());

var_dump(Staple\Helpers::parameterize('This world go crazy pa-pawh!'));
var_dump(Staple\Helpers::underscore('This world go crazy pa-pawh!'));
var_dump(Staple\Helpers::underscore('ShutUpBro'));
var_dump(Staple\Helpers::classify('shut-up-bro'));
var_dump(Staple\Helpers::titlecase('i-am-and-this-is-a-great-thing'));

echo "\n";
