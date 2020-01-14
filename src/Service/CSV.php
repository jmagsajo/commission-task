<?php

declare(strict_types=1);

namespace App\CommissionTask\Service;

class CSV
{
    public $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function parseCSV()
    {
        $f = fopen($this->path, 'r');

        return $f;
    }

    public function closeFile($f)
    {
        fclose($f);
    }
}
