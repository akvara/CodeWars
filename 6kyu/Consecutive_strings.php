<?php

include_once __DIR__.'/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;

function longestConsec($strarr, $k) {
    $n = count($strarr);

    if ($n === 0 || $k > $n || $k <= 0) return "";

    $res = "";
    $maxlen = 0;

    for ($i = 0; $i <= $n-$k; $i++) {
        $s = implode(array_slice($strarr, $i, $k));
        if (strlen($s) > $maxlen) {
            $maxlen = strlen($s);
            $res = $s;
        }
    }
    return $res;
}

class ConsecutiveTestCases extends TestCase
{
    private function revTest($actual, $expected) {
        $this->assertEquals($expected, $actual);
    }
    public function testBasics() {
        $this->revTest(longestConsec(["zone", "abigail", "theta", "form", "libe", "zas"], 2), "abigailtheta");
        $this->revTest(longestConsec(["ejjjjmmtthh", "zxxuueeg", "aanlljrrrxx", "dqqqaaabbb", "oocccffuucccjjjkkkjyyyeehh"], 1), "oocccffuucccjjjkkkjyyyeehh");
        $this->revTest(longestConsec([], 3), "");
    }
}

$t = new ConsecutiveTestCases();
$t->testBasics();
