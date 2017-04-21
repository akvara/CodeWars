<?php

include_once __DIR__.'/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;

function findIt(array $seq) : int
{
    $data = [];
    foreach ($seq as $item) {
        if (!isset($data[strval($item)])) $data[strval($item)] = 0;
        $data[strval($item)]++;
    }
    do {
        if (current($data) % 2 !== 0) return key($data);
        next($data);
    } while (true);
    return null;
}

class BasicTestCases extends TestCase
{
    public function testFindItReturnsValueAppearingOddNumberOfTimes()
    {
        $this->assertEquals(5, findIt([20,1,-1,2,-2,3,3,5,5,1,2,4,20,4,-1,-2,5]));
        $this->assertEquals(-1, findIt([1,1,2,-2,5,2,4,4,-1,-2,5]));
        $this->assertEquals(5, findIt([20,1,1,2,2,3,3,5,5,4,20,4,5]));
        $this->assertEquals(10, findIt([10]));
        $this->assertEquals(10, findIt([1,1,1,1,1,1,10,1,1,1,1]));
    }
}

$t = new BasicTestCases();
$t->testFindItReturnsValueAppearingOddNumberOfTimes();
