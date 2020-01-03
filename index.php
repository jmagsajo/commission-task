<?php
define('ROOT', __DIR__);

require_once(ROOT .'/vendor/autoload.php');

require_once(ROOT .'/src/Service/Computation.php');

$csv = $argv[1]; //read second argument

$compute = new Computation($csv);