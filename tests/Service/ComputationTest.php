<?php

declare(strict_types=1);

namespace App\CommissionTask\Tests\Service;

use PHPUnit\Framework\TestCase;
use App\CommissionTask\Controller\ComputationController as Computation;

class ComputationTest extends TestCase
{
    /**
     * @var Math
     */
    private $computation;

    public function setUp()
    {
        $this->computation = new Computation("test.csv");
    }

    /**
     * @param array $expectation
     *
     * @dataProvider dataProviderForCSVFileTesting
     */
    public function testComputation(array $expectation)
    {
        $this->assertEquals(
            $expectation,
            $this->computation->computation()
        );
    }

    public function dataProviderForCSVFileTesting(): array
    {
        return [
            'csv file computation expectation' => [
                                    [
                                        "0" => "3.60",
                                        "1" => "3.00",
                                        "2" => "3.00",
                                        "3" => "0.60",
                                        "4" => "0.50",
                                        "5" => "3.00",
                                        "6" => "0.30",
                                        "7" => "5.00",
                                        "8" => "3.00",
                                        "9" => "0.90",
                                        "10" => "0.30",
                                        "11" => "9,001.04",
                                    ]  
                                ]
        ];
    }

}
