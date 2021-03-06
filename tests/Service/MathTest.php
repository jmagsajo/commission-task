<?php

declare(strict_types=1);

namespace App\CommissionTask\Tests\Service;

use PHPUnit\Framework\TestCase;
use App\CommissionTask\Service\Math;

class MathTest extends TestCase
{
    /**
     * @var Math
     */
    private $math;

    public function setUp()
    {
        $this->math = new Math(2);
    }

    /**
     * @param string $leftOperand
     * @param string $rightOperand
     * @param string $expectation
     *
     * @dataProvider dataProviderForAddTesting
     */
    public function testAdd(string $leftOperand, string $rightOperand, string $expectation)
    {
        $this->assertEquals(
            $expectation,
            $this->math->add($leftOperand, $rightOperand)
        );
    }

    public function dataProviderForAddTesting(): array
    {
        return [
            'add 2 natural numbers' => ['1', '2', '3'],
            'add negative number to a positive' => ['-1', '2', '1'],
            'add natural number to a float' => ['1', '1.05123', '2.05'],
        ];
    }

    /**
     * @param string $leftOperand
     * @param string $rightOperand
     * @param string $expectation
     *
     * @dataProvider dataProviderForMulTesting
     */
    public function testMul(string $leftOperand, string $rightOperand, string $expectation)
    {
        $this->assertEquals(
            $expectation,
            $this->math->mul($leftOperand, $rightOperand)
        );
    }

    public function dataProviderForMulTesting(): array
    {
        return [
            'multiply 2 natural numbers' => ['1', '2', '2'],
            'multiply negative number to a positive' => ['-1', '2', '-2'],
            'multiply natural number to a float' => ['1', '1.05123', '1.05'],
        ];
    }
    
    /**
     * @param string $leftOperand
     * @param string $rightOperand
     * @param string $expectation
     *
     * @dataProvider dataProviderForDivTesting
     */
    public function testDiv(string $leftOperand, string $rightOperand, string $expectation)
    {
        $this->assertEquals(
            $expectation,
            $this->math->div($leftOperand, $rightOperand)
        );
    }

    public function dataProviderForDivTesting(): array
    {
        return [
            'divide 2 natural numbers' => ['100', '2', '50'],
            'divide negative number to a positive' => ['-2', '2', '-1'],
            'divide natural number to a float' => ['1', '1.05123', '0.95'],
        ];
    }

}
