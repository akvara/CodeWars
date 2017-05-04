<?php

include_once __DIR__.'/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;

function bits_battle($numbers) {
    $odd_gain = 0;
    $even_gain = 0;
    foreach ($numbers as $number) {
        if ($number === 0) continue;
        if ($number % 2 === 0) $even_gain += fight_force($number); else $odd_gain += fight_force($number);
    }
    if ($odd_gain > $even_gain) return "odds win";
    if ($odd_gain < $even_gain) return "evens win";
    return "tie";
}

function fight_force($number) {
    $bin = decbin($number);
    $force = '1';
    if ($number % 2 === 0) $force = '0';

    return substr_count($bin, $force);
}

class MyTestCases extends TestCase {
    public function testBasic() {
        $this->assertEquals('odds win', bits_battle([5, 3, 14]));
        $this->assertEquals('evens win', bits_battle([3, 8, 22, 15, 78]));
        $this->assertEquals('tie', bits_battle([]));
        $this->assertEquals('tie', bits_battle([1, 13, 16]));
    }
}

$t = new MyTestCases();
$t->testBasic();
