<?php

declare(strict_types=1);

namespace App\CommissionTask\Controller;

use App\CommissionTask\Service\Computation;
use App\CommissionTask\Service\CSV;

class ComputationController
{
    public $path;
    public $csv;
    public $computation;

    public function __construct($path)
    {
        $this->csv = new CSV($path);
        $this->computation = new Computation();
    }

    public function computation(): array
    {
        $f = $this->csv->parseCSV();

        $output = $this->computation->feeComputation($f);

        $this->csv->closeFile($f);

        return $output;
    }
}
