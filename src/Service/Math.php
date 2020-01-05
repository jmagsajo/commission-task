<?php

declare(strict_types=1);

namespace App\CommissionTask\Service;

class Math
{
    private $scale;

    public function __construct(int $scale)
    {
        $this->scale = $scale;
    }

    public function add(string $leftOperand, string $rightOperand): string
    {
        return bcadd($leftOperand, $rightOperand, $this->scale);
    }
    
    public function mul(string $leftOperand, string $rightOperand): string
    {
        return bcmul($leftOperand, $rightOperand, $this->scale);
    }

    public function div(string $leftOperand, string $rightOperand): string
    {
        return bcdiv($leftOperand, $rightOperand, $this->scale);
    }
}
