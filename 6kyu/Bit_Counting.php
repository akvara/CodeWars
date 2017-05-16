<?php

include_once __DIR__.'/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;

function countBits($n)
{
    return substr_count(decbin($n), '1');
}

class CountBitsTestCases extends TestCase
{
    public function testResultCountBits() {
        $this->assertEquals(countBits(0), 0);
        $this->assertEquals(countBits(4), 1);
        $this->assertEquals(countBits(7), 3);
        $this->assertEquals(countBits(9), 2);
        $this->assertEquals(countBits(10), 2);
    }
}

$t = new CountBitsTestCases();
$t->testResultCountBits();

