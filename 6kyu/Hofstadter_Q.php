<?php

include_once __DIR__.'/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;

function hofstadter_q(int $n): int {
    $res = [0, 1, 1];
    for ($i = 3; $i <= $n; $i++) {
        $res[$i] = $res[$i - $res[$i - 1]] + $res[$i - $res[$i - 2]];
    }
    return $res[$n];
}

class HofstadterQTest extends TestCase {
    public function testExamples() {
        $this->assertEquals(1, hofstadter_q(1));
        $this->assertEquals(2, hofstadter_q(3));
        $this->assertEquals(5, hofstadter_q(7));
        $this->assertEquals(6, hofstadter_q(10));
        $this->assertEquals(502, hofstadter_q(1000));
    }
}

$t = new HofstadterQTest();
$t->testExamples();
