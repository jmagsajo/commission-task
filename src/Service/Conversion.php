<?php

declare(strict_types=1);

namespace App\CommissionTask\Service;

class Conversion
{
    public function __construct()
    {
        $this->usd = config('usd');
        $this->jpy = config('jpy');
        $this->commission = config('commission');
        $this->math = new Math(config('decimal_place'));
    }

    public function convertCurrency($currency, $commission_fee): float
    {
        if ($currency === 'USD') {
            return (float) $this->math->mul(strval($commission_fee), strval($this->usd));
        } elseif ($currency === 'JPY') {
            return (float) $this->math->mul(strval($commission_fee), strval($this->jpy));
        } else {
            return (float) $commission_fee;
        }
    }
}
