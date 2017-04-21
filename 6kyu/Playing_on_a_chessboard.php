<?php

include_once __DIR__.'/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;

function game(int $n): array {
    $halves = $n ** 2;
    return ($halves % 2 === 0) ? [intdiv($halves, 2)] : [$halves, 2];
}


class ChessBoardCases extends TestCase
{
    public function testBasics() {
        $this->assertEquals([0], game(0));
        $this->assertEquals([1, 2], game(1));
        $this->assertEquals([32], game(8));
        $this->assertEquals([800], game(40));
    }
}

$a = new ChessBoardCases();
$a->testBasics();
