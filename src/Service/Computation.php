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
        if($currency == "USD")
        {
            return (float) $this->math->mul( strval($commission_fee), strval($this->usd));
        }
        else if($currency == "JPY")
        {
            return (float) $this->math->mul( strval($commission_fee), strval($this->jpy) );
        }
        else
        {
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

            if($currency == "JPY")
            {
                $cash = $this->math->div(strval($cash), strval($this->jpy));
            }
            else if($currency == "USD")
            {
                $cash = $this->math->div(strval($cash), strval($this->usd));
            }
            
            $commission_fee = (float) $this->math->mul(strval($cash), strval($this->commission));
            $commission_fee = round(ceil($commission_fee*100)/100, 2);

            switch($data[3])
            {
                case "cash_out" :
                    $person = $data[2];
                    if($person == "legal"){
                        if($commission_fee > 0.50 )
                        {
                            $commission_fee = $this->convertCurrency($currency, 0.50);
                            array_push($output, number_format( (float) $commission_fee, 2));
                        }
                        else
                        {
                            $commission_fee = $this->convertCurrency($currency, $commission_fee);
                            $total = number_format( (float) $commission_fee, 2);
                            array_push($output, $total);
                        }
                    }else{
                        
                        $commission_fee = $this->convertCurrency($currency, $commission_fee);
                        $total = number_format( (float) $commission_fee, 2);
                        array_push($output, $total);
                    
                    }

                break;
                case "cash_in" :
                    if($commission_fee > 5 )
                    {
                        $commission_fee = $this->convertCurrency($currency, 5.00);
                        array_push($output,  number_format( (float) $commission_fee, 2) );
                    }
                    else
                    {
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