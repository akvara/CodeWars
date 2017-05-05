<?php

include_once __DIR__.'/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;

function inArray($array1, $array2) {
    $res = [];
    foreach ($array1 as $needle) {
        foreach ($array2 as $haystack) {
            if (strpos($haystack, $needle) !== false) $res[] = $needle;
        }
    }
    sort($res);
    return array_values(array_unique($res));
}


class WhichAreInTestCases extends TestCase
{
    private function revTest($actual, $expected) {
        $this->assertEquals($expected, $actual);
    }
    public function testBasics() {
        $a2 = ["lively", "alive", "harp", "sharp", "armstrong"];
        $a1 = ["arp", "live", "strong"];
        $this->revTest(inArray($a1, $a2), ["arp", "live", "strong"]);
        $a1 = ["xyz", "live", "strong"];
        $this->revTest(inArray($a1, $a2), ["live", "strong"]);
        $a1 = ["live", "strong", "arp"];
        $this->revTest(inArray($a1, $a2), ["arp", "live", "strong"]);
    }

}


$t = new WhichAreInTestCases();
$t->testBasics();
