<?php

include_once __DIR__.'/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;

function howmuch($m, $n) {
    $res = [];
    for ($f = min($m, $n); $f <= max($m, $n); $f++) {
        $c = 0;
        $b = 0;
        if ($f % 9 === 1) $c = intdiv($f, 9);
        if ($f % 7 === 2) $b = intdiv($f, 7);
        if ($c > 0 && $b > 0) $res[] = ["M: $f", "B: $b", "C: $c"];
    }
    return $res;
}

class HowMuchCases extends TestCase
{
    public function testBasics() {
        $this->assertEquals([["M: 37", "B: 5", "C: 4"], ["M: 100", "B: 14", "C: 11"]], howmuch(1, 100));
        $this->assertEquals([["M: 1045", "B: 149", "C: 116"]], howmuch(1000, 1100));
        $this->assertEquals([["M: 9991", "B: 1427", "C: 1110"]], howmuch(10000, 9950));
    }
}

$t = new HowMuchCases();
$t->testBasics();
