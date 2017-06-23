<?php

include_once __DIR__.'/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;


function fusc(int $n): int {
    if ($n === 0) return 0;
    if ($n === 1) return 1;
    if ($n % 2 === 0 ) return fusc(intdiv($n, 2));
    return fusc(intdiv($n, 2)) + fusc(intdiv($n, 2) + 1);
}


class FuscTest extends TestCase {
    public function testExamples() {
        $this->assertEquals(0, fusc(0));
        $this->assertEquals(1, fusc(1));
        $this->assertEquals(21, fusc(85));
    }
}

$t = new FuscTest();
$t->testExamples();

