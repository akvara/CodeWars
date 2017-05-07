<?php

include_once __DIR__.'/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;

function balanceStatements($list) {
    $arr = explode(",", $list);
    $i = 0;
    $fail = '';
    $buy = 0;
    $sell = 0;
    foreach ($arr as $order) {
        if (!trim($order)) continue;
        if (!preg_match('/([\.A-Z0-9]+) (\d+) (\d*\.\d+) (B|S)/', trim($order), $matches)) {
            $i++;
            $fail .= trim($order) . " ;";
            continue;
        }
        if ($matches[4] === 'B') {
            $buy += $matches[2] * $matches[3];
            continue;
        }
        $sell += $matches[2] * $matches[3];

    }
    $res = sprintf("Buy: %d Sell: %d", round($buy), round($sell));
    if ($fail) $res .= sprintf("; Badly formed %d: %s", $i, $fail);

    return $res;
}

class StockBrokerTestCases extends TestCase {
    private function revTest($actual, $expected) {
        $this->assertEquals($expected, $actual);
    }
    public function testBasics() {
        $l = "GOOG 300 542.0 B, AAPL 50 145.0 B, CSCO 250.0 29 B, GOOG 200 580.0 S";
        $sol = "Buy: 169850 Sell: 116000; Badly formed 1: CSCO 250.0 29 B ;";
        $this->revTest(balanceStatements($l), $sol);
        $l = "";
        $sol = "Buy: 0 Sell: 0";
        $this->revTest(balanceStatements($l), $sol);
    }
}

$t = new StockBrokerTestCases();
$t->testBasics();
