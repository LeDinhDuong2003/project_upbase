<?php

namespace Tests\Unit;

use App\Services\Calculator;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $calculator = new Calculator();
        $result = $calculator->add(1,2);
        $this->assertEquals($result,3);
    }
    public function test_example_2(): void
    {
        $calculator = new Calculator();
        $result = $calculator->add(-1,2);
        $this->assertEquals($result,1);
    }
}
