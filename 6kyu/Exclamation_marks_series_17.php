<?php

include_once __DIR__.'/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;

function balance(string $l, string $r): string {
    $res = mark_count($l) <=> mark_count($r);
    if ($res > 0) return ('Left');
    if ($res === 0) return ('Balance');
    return ('Right');
}

function mark_count(string $str):int {
    return substr_count( $str, '?') * 3 + substr_count($str, '!') * 2;
}

class BalanceTest extends TestCase {
    public function testExamples() {
        $this->assertEquals("Right", balance("!!", "??"));
        $this->assertEquals("Left", balance("!??", "?!!"));
        $this->assertEquals("Left", balance("!?!!", "?!?"));
        $this->assertEquals("Balance", balance("!!???!????", "??!!?!!!!!!!"));
    }
}

$t = new BalanceTest();
$t->testExamples();

