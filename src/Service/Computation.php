<?php

declare(strict_types=1);

namespace App\CommissionTask\Service;

class Computation
{
    public $path;

    public function __construct($path)
    {
        $this->path = $path;    
    }

    public function computation(): string
    {   
        $f = fopen($this->path, 'r');

        print_r(fgetcsv($f));

        fclose( $f );
    }
}