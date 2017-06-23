<?php

include_once __DIR__.'/vendor/autoload.php';
use PHPUnit\Framework\TestCase;

/* nemano */
function fusc(int $n): int {
    static $lookup = [0, 1];
    if (isset($lookup[$n])) return $lookup[$n];
    if ($n % 2 === 0) return $lookup[$n] = fusc($n / 2);
    return $lookup[$n] = fusc(($n - 1) / 2) + fusc(($n + 1) / 2);
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

