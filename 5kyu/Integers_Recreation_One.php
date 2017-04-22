<?php

include_once __DIR__.'/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;

function listSquared($m, $n) {
    $res = [];

    for ($i = $m; $i <= $n; $i++) {
        $sum = sum_of_squared_divisors($i);
        $root = sqrt($sum);
        if ($root === floor($root) && $root === ceil($root)) $res[] = [$i, $sum];
    }
    return $res;
}

function sum_of_squared_divisors(int $n): int {
    $res = 1;

    for ($i = 2; $i <= sqrt($n); $i++) {
        if ($n % $i === 0) {
            $res += $i * $i;
            $rev = $n / $i;
            if ($rev !== $i) $res += $rev * $rev;
        }
    }

    if ($n > 1) $res += $n * $n;

    return $res;
}


class IntegerRecreationTestCases extends TestCase {
    private function revTest($actual, $expected) {
        $this->assertEquals($expected, $actual);
    }
    public function testBasics() {
        $this->revTest(listSquared(1, 250), [[1, 1], [42, 2500], [246, 84100]]);
        $this->revTest(listSquared(42, 250), [[42, 2500], [246, 84100]]);
        $this->revTest(listSquared(250, 500), [[287, 84100]]);
        $this->revTest(listSquared(300, 600), []);
    }
}

$a = new IntegerRecreationTestCases();
$a->testBasics();
