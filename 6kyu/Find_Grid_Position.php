<?php

include_once __DIR__.'/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;

function create_grid($m, $n, $position)
{
    $res = '';

    $background = '0';
    $line = '1';
    $crossing = '*';
    if ($position['y'] >= $m || $position['x'] >= $n) {
        $line = '0';
        $crossing = '0';
    }
    for ($y = 0; $y < $m; $y++) {
        $res .= strlen($res) > 0 ? '\n' : '';
        $res .= $y === $position['y'] ?
            filled_line($line, $crossing, $n, $position['x']) :
            filled_line($background, $line, $n, $position['x']);
    }
    return $res;
}

function filled_line($regular, $crossed, $len, $at) {
    return str_pad($crossed, min($at + 1, $len), $regular, STR_PAD_LEFT) . str_pad('', $len - $at - 1, $regular, STR_PAD_RIGHT);
}

class MyTestCases extends TestCase
{
    public function testStaticOperations()
    {
        $this->assertEquals('*', create_grid(1, 1, ["x" => 0, "y" => 0]));
        $this->assertEquals('*1111', create_grid(1, 5, ["x" => 0, "y" => 0]));
        $this->assertEquals('00000001\n00000001\n00000001\n1111111*', create_grid(4, 8, ["x" => 7, "y" => 3]));
    }
}

$t = new MyTestCases();
$t->testStaticOperations();
