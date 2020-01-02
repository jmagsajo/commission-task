<?php
$csv = $argv[1]; //read second argument

$f = fopen($csv, 'r');

print_r(fgetcsv($f));

fclose( $f );