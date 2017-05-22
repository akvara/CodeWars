<?php

include_once __DIR__.'/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;

function arrange($strng) {
    $arr = explode(' ', $strng);

    $ordered = false;
    while (!$ordered) {
        $ordered = true;
        for ($i = 1; $i < count($arr); $i++) {
            if ($i % 2 === 0) {
                if (strlen($arr[$i]) > strlen($arr[$i - 1])) {
                    arr_move($arr, $i);
                    $ordered = false;
                }
            } else {
                if (strlen($arr[$i]) < strlen($arr[$i - 1])) {
                    arr_move($arr, $i);
                    $ordered = false;
                }
            }
        }
    }

    for ($i = 0; $i < count($arr); $i++) {
        $arr[$i] = ($i % 2 === 0) ? strtolower($arr[$i]) : strtoupper($arr[$i]);
    }
    return implode($arr, ' ');
}

function arr_move(array &$arr, int $i) {
    $tmp = $arr[$i];
    $arr[$i] = $arr[$i - 1];
    $arr[$i - 1] = $tmp;
}

class UpAndDownTestCases extends TestCase
{
    private function revTest($actual, $expected) {
        $this->assertEquals($expected, $actual);
    }
    public function testBasics() {
        $this->revTest(arrange("who hit retaining The That a we taken"), "who RETAINING hit THAT a THE we TAKEN"); // 3
        $this->revTest(arrange("on I came up were so grandmothers"), "i CAME on WERE up GRANDMOTHERS so"); // 4
        $this->revTest(arrange("way the my wall them him"), "way THE my WALL him THEM"); // 1
        $this->revTest(arrange("turn know great-aunts aunt look A to back"), "turn GREAT-AUNTS know AUNT a LOOK to BACK"); // 2
    }
}

$t = new UpAndDownTestCases();
$t->testBasics();

