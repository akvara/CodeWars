<?php

include_once __DIR__.'/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;

function next_gen(array $cells): array {
    $new_gen = $cells;
    for ($y = 0; $y < count($cells); $y++) {
        for ($x = 0; $x < count($cells[0]); $x++) {
            $new_gen[$y][$x] = survives(count_living_neighbours($cells, $x, $y), is_living($cells, $x, $y));
        }
    }
    return $new_gen;
}

function survives($neighbours, $is_living): bool {
    if ($neighbours < 2 || $neighbours > 3) return false;
    if ($neighbours === 3) return true;
    return $is_living;
}

function is_living($cells, $x, $y): bool {
    if ($x < 0) return false;
    if ($x >= count($cells[0])) return false;
    if ($y < 0) return false;
    if ($y >= count($cells)) return false;

    return $cells[$y][$x] === 1;
}

function count_living_neighbours($cells, $x, $y): int {
    return
        is_living($cells, $x-1, $y-1) +
        is_living($cells, $x,   $y-1) +
        is_living($cells, $x+1, $y-1) +
        is_living($cells, $x-1, $y) +
        is_living($cells, $x+1, $y) +
        is_living($cells, $x-1, $y+1) +
        is_living($cells, $x,   $y+1) +
        is_living($cells, $x+1, $y+1);
}


class ConwaysGameOfLifeTest extends TestCase {
    public function testExamples() {
        // Empty Universe
        $this->assertEquals([], next_gen([]));
        // Block
        $this->assertEquals([
            [1, 1],
            [1, 1]
        ], next_gen([
            [1, 1],
            [1, 1]
        ]));
    }
}

$t = new ConwaysGameOfLifeTest();
$t->testExamples();
