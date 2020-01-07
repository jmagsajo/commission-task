<?php

declare(strict_types=1);

namespace App\CommissionTask\Service;

use App\CommissionTask\Service\Math;

class Computation
{
    public $path;
    public $usd = 1.1497;
    public $jpy = 129.53;
    public $commission = 0.003;
    public $math;

    public function __construct($path)
    {
        $this->path = $path;
        $this->math = new Math(3);
    }

    public function convertCurrency($currency, $commission_fee): float
    {
        if ($currency == "USD") {
            return (float) $this->math->mul( strval($commission_fee), strval($this->usd));
        } elseif ($currency == "JPY") {
            return (float) $this->math->mul( strval($commission_fee), strval($this->jpy) );
        } else {
            return (float) $commission_fee;
        }
    }

    public function computation(): array
    {   
        $f = fopen($this->path, 'r');
        $output = [];
        while(! feof($f))
        {   
            $data = fgetcsv($f);
            $cash = $data[4];
            $currency = $data[5];

            if ($currency == "JPY") {
                $cash = $this->math->div(strval($cash), strval($this->jpy)); //if the currency is jpy the cash will e converted to jpy
            } elseif($currency == "USD") {
                $cash = $this->math->div(strval($cash), strval($this->usd)); //if the currency is usd the cash will e converted to usd
            }
            /* commission fee calculation*/
            $commission_fee = (float) $this->math->mul(strval($cash), strval($this->commission));
            $commission_fee = round(ceil($commission_fee*100)/100, 2); //cents is always ceiled

            switch($data[3])
            {
                case "cash_out" :
                    $person = $data[2];
                    if($person == "legal"){
                        if ($commission_fee > 0.50 ) { //legal person Commission fee - 0.3% from amount, but not less than 0.50 EUR for operation.
                        
                            $commission_fee = $this->convertCurrency($currency, 0.50);
                            array_push($output, number_format( (float) $commission_fee, 2));
                        } else {
                            $commission_fee = $this->convertCurrency($currency, $commission_fee);
                            $total = number_format( (float) $commission_fee, 2);
                            array_push($output, $total);
                        }
                    } else { //natural person Commission fee - 0.3% from cash out amount.
                        
                        $commission_fee = $this->convertCurrency($currency, $commission_fee);
                        $total = number_format( (float) $commission_fee, 2);
                        array_push($output, $total);
                    
                    }

                break;
                case "cash_in" :
                    if ($commission_fee > 5 ) { //cash in Commission fee - 0.03% from total amount, but no more than 5.00 EUR.
                        $commission_fee = $this->convertCurrency($currency, 5.00);
                        array_push($output,  number_format( (float) $commission_fee, 2) );
                    } else {
                        $commission_fee = $this->convertCurrency($currency, $commission_fee);
                        $total = number_format( (float) $commission_fee, 2);
                        array_push($output, $total);
                    }
                break;
            }
        }
        
        fclose( $f );

        return $output;
    }
}