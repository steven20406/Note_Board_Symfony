<?php

use BankingBundle\Calculator;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase {
    public function testAdd(){
        $calc = new Calculator();
        $result = $calc->add(30,12);

        $this->assertEquals(42, $result);
    }
}
