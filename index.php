<?php
define('ROOT', __DIR__);

require_once(ROOT .'/vendor/autoload.php');

use App\CommissionTask\Service\Computation;

$csv = $argv[1]; //read second argument

$compute = new Computation($csv);
$computation = $compute->computation();
$output = "";
foreach($computation as $i => $value){
    $output .= $value."\n";
}

fwrite(STDOUT, $output);