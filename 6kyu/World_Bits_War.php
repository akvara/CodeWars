<?php

include_once __DIR__.'/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;

function bitsWar($numbers){
    $odd_gain = 0;
    $even_gain = 0;
    foreach ($numbers as $number) {
        if ($number === 0) continue;
        $sign = 1;
        if ($number < 0) $sign = -1;
        if ($number % 2 === 0)
            $even_gain += $sign * fight_force(abs($number));
        else
            $odd_gain +=$sign * fight_force(abs($number));
    }
    if ($odd_gain > $even_gain) return "odds win";
    if ($odd_gain < $even_gain) return "evens win";
    return "tie";
}

function fight_force($number) {
    $bin = decbin($number);
    return substr_count($bin, '1');
}

class MyTestCases extends TestCase
{
    public function testThatSomethingShouldHappen() {
        $this->assertEquals("odds win", bitsWar([1,5,12]));
        $this->assertEquals( "evens win",bitsWar([7,-3,20]));
        $this->assertEquals("tie",bitsWar([7,-3,-2,6]));
        $this->assertEquals("evens win",bitsWar([-3,-5]));
        $this->assertEquals("tie",bitsWar([]));
    }
}

$t = new MyTestCases();
$t->testThatSomethingShouldHappen();
