<?php

include_once __DIR__.'/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;

function encodeStr($s, $shift) {
    $res = '';

    $pref = strtolower($s[0]);
    $pref .= shift($pref, $shift);

    for ($i = 0; $i < strlen($s); $i++) {
        $res .= shift($s[$i], $shift);
    }

    $res = $pref . $res;
    $arr = str_split($res, ceil(strlen($res) / 5));

    return $arr;
}

function decode($arr) {
    $s = implode('', $arr);
    $res = '';
    $shift = ord($s[1]) - ord($s[0]);

    $s = substr($s, 2);
    for ($i = 0; $i < strlen($s); $i++) {
        $res .= shift($s[$i], -$shift);
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

class Caesar2TestCases extends TestCase {
    private function dotest1($u, $k, $v) {
        echo "Testing encodeStr\n";
        $this->assertEquals($v, encodeStr($u, $k));
    }
    private function dotest2($u, $v) {
        echo "Testing decode\n";
        $this->assertEquals($v, decode($u));
    }
    public function test() {
        $u = "I should have known that you would have a perfect answer for me!!!";
        $v = ["ijJ tipvme ibw", "f lopxo uibu z", "pv xpvme ibwf ", "b qfsgfdu botx", "fs gps nf!!!"];
        $this->dotest1($u, 1, $v);
        $this->dotest2($v, $u);
    }
}


$t = new Caesar2TestCases();
$t->test();

