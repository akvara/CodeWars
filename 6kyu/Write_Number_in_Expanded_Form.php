<?php

include_once __DIR__.'/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;

function expanded_form(int $n): string {
    $zeros = 0;
    $res = '';
    while ($n > 0) {
        $rem = $n % 10;
        $zeros++;
        if ($rem > 0) $res = str_pad(strval($rem), $zeros, '0', STR_PAD_RIGHT) . ($res === '' ? '' : " + ") . $res;
        $n = intdiv($n, 10);
    }
    return $res;
}

class ExpandedFormTest extends TestCase {
    public function testDescriptionExamples() {
        $this->assertEquals("10 + 2", expanded_form(12));
        $this->assertEquals("40 + 2", expanded_form(42));
        $this->assertEquals("70000 + 300 + 4", expanded_form(70304));
    }
}

$t = new ExpandedFormTest();
$t->testDescriptionExamples();
