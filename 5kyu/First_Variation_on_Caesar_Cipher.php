<?php

include_once __DIR__.'/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;

function movingShift($s, $shift) {
    $res = '';
    for ($i = 0; $i < strlen($s); $i++) {
        $res .= shift($s[$i], $shift + $i);
    }

    $arr = str_split($res, ceil(strlen($res) / 5));
    if (count($arr) < 5 ) $arr[] = '';

    return $arr;
}

function demovingShift($arr, $shift) {
    $s = implode('', $arr);
    $res = '';
    for ($i = 0; $i < strlen($s); $i++) {
        $res .= shift($s[$i], -($shift + $i));
    }
    return $res;

}

function shift($char, $shift)
{
    $ord = ord($char);

    if ($ord < ord('A') || $ord > ord('z') || $ord < ord('a') && $ord > ord('Z')) return $char;

    if ($ord >= ord('a') && $ord <= ord('z')) return chr(roundShift($ord, $shift,  ord('a'), ord('z')));

    return chr(roundShift($ord, $shift,  ord('A'), ord('Z')));
}

function roundShift($ord, $shift, $first, $last) {
    $ord = $ord + $shift;
    while ($ord > $last) $ord = $ord - $last + $first - 1;
    while ($ord < $first) $ord = $ord + $last - $first + 1;

    return $ord;
}

class Caesar1TestCases extends TestCase {
    private function dotest1($u, $k, $v) {
        echo "Testing movingShift\n";
        $this->assertEquals($v, movingShift($u, $k));
    }
    private function dotest2($u, $k, $v) {
        echo "Testing demovingShift\n";
        $this->assertEquals($v, demovingShift($u, $k));
    }
    private function dotest3($u, $k) {
        echo "Testing movingShift and demovingShift\n";
        $this->assertEquals($u, demovingShift(movingShift($u, $k), $k));
    }
    public function test() {
        $u = "I should have known that you would have a perfect answer for me!!!";
        $sol = ["J vltasl rlhr ", "zdfog odxr ypw", " atasl rlhr p ", "gwkzzyq zntyhv", " lvz wp!!!"];
        $this->dotest1($u, 1, $sol);
        $this->dotest2($sol, 1, $u);
        $this->dotest3($u, 1);
    }
}

$t = new Caesar1TestCases();
$t->test();
