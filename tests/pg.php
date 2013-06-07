<?php

$autoload = require dirname(__DIR__).DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';

$c = get_defined_constants();

$pg = \Staple\Paginate::build();

$pg->set('per_page', 13);
$pg->set('link_root', $_SERVER['PHP_SELF']);
$pg->set('total_items', sizeof($c));
$pg->set('current', isset($_GET['p']) ? $_GET['p'] : 0);
$pg->bind($c);

#echo '<pre>';
#var_dump($pg->result());
#var_dump($pg->offset());
#echo '</pre>';

echo "$pg<br>";

foreach ($pg as $k => $v) {
  echo "\n<br>$k = $v";
}

echo "\n<br><br>";
