<?php

declare(strict_types=1);

namespace App\CommissionTask\Service;

class Computation
{
    public $usd;
    public $jpy;
    public $commission_fee;
    public $math;
    public $conversion;

    public function __construct()
    {
        $this->usd = config('usd');
        $this->jpy = config('jpy');
        $this->commission_fee = config('commission');
        $this->math = new Math(config('decimal_place'));
        $this->conversion = new Conversion();
    }

    public function feeComputation($f): array
    {
        $output = [];
        while (!feof($f)) {
            $data = fgetcsv($f);
            $cash = $data[4];
            $currency = $data[5];

            if ($currency === 'JPY') {
                $cash = $this->math->div(strval($cash), strval($this->jpy)); //if the currency is jpy the cash will e converted to jpy
            } elseif ($currency === 'USD') {
                $cash = $this->math->div(strval($cash), strval($this->usd)); //if the currency is usd the cash will e converted to usd
            }
            /* commission fee calculation*/
            $commission_fee = (float) $this->math->mul(strval($cash), strval($this->commission_fee));
            $commission_fee = round(ceil($commission_fee * 100) / 100, 2); //cents is always ceiled

            switch ($data[3]) {
                case 'cash_out':
                    $person = $data[2];
                    if ($person === 'legal') {
                        if ($commission_fee > 0.50) { //legal person Commission fee - 0.3% from amount, but not less than 0.50 EUR for operation.
                            $commission_fee = $this->conversion->convertCurrency($currency, 0.50);
                            array_push($output, number_format((float) $commission_fee, 2));
                        } else {
                            $commission_fee = $this->conversion->convertCurrency($currency, $commission_fee);
                            $total = number_format((float) $commission_fee, 2);
                            array_push($output, $total);
                        }
                    } else { //natural person Commission fee - 0.3% from cash out amount.
                        $commission_fee = $this->conversion->convertCurrency($currency, $commission_fee);
                        $total = number_format((float) $commission_fee, 2);
                        array_push($output, $total);
                    }

                break;
                case 'cash_in':
                    if ($commission_fee > 5) { //cash in Commission fee - 0.03% from total amount, but no more than 5.00 EUR.
                        $commission_fee = $this->conversion->convertCurrency($currency, 5.00);
                        array_push($output, number_format((float) $commission_fee, 2));
                    } else {
                        $commission_fee = $this->conversion->convertCurrency($currency, $commission_fee);
                        $total = number_format((float) $commission_fee, 2);
                        array_push($output, $total);
                    }
                break;
            }
        }

        return $output;
    }
}
