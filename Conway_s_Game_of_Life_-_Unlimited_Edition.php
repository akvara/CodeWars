<?php

include_once __DIR__.'/vendor/autoload.php';
use PHPUnit\Framework\TestCase;

function get_generation(array $cells, int $generations): array {

//    var_dump($generations);
//    var_dump($cells);

    $new_gen = $cells;
    for ($g = 1; $g <= $generations; $g++) {
        $new_gen = truncate(one_generation($cells));
    }
    return $new_gen;
}

function one_generation(array $cells): array {
    $new_gen = [[]];

    for ($y = -1; $y <= count($cells); $y++) {
        for ($x = -1; $x <= count($cells[0]); $x++) {
            $new_gen[$y+1][$x+1] = survives(count_living_neighbours($cells, $x, $y), is_living($cells, $x, $y));
        }
    }

    return $new_gen;
}

function truncate(array $cells): array {
    $startX = find_first_inhabitated_column($cells, 1);
    $endX = find_first_inhabitated_column($cells, -1);
    $startY = find_first_inhabitated_row($cells, 1);
    $endY = find_first_inhabitated_row($cells, -1);
    $truncated = [];

    for ($y = $startY; $y <= $endY; $y++) {
        $row = [];
        for ($x = $startX; $x <= $endX; $x++) {
            $row[] = $cells[$y][$x] ? 1 : 0;
        }
        $truncated[] = $row;
    }

    return $truncated;
}

function find_first_inhabitated_row(array $cells, int $direction): int {
    $row = 0;
    if ($direction < 0) $row = count($cells) - 1;
    $inhabited = false;
    while (!$inhabited && $row >=0 && $row < count($cells)) {
        foreach ($cells[$row] as $cell) {
            $inhabited = $inhabited || $cell;
        }
        if (!$inhabited) $row += $direction;
    }

    return $row;
}

function find_first_inhabitated_column(array $cells, int $direction): int {
    $col = 0;
    if ($direction < 0) $col = count($cells[0]) - 1;
    $inhabited = false;
    while (!$inhabited && $col >=0 && $col < count($cells[0])) {
        for ($row = 0; $row < count($cells); $row++) {
            $inhabited = $inhabited || $cells[$row][$col];
        }
        if (!$inhabited) $col += $direction;
    }

    return $col;
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

function htmlize($cells) {
    $out = "";
    foreach ($cells as $row) {
        foreach ($row as $cell) {
            $out .= $cell ? "X" : "_";
        }
        $out .= "\r\n";
    }
    return $out;
}

class ConwaysGameOfLifeUnlimitedEditionTest extends TestCase {
    public function testExample() {
        // Basic Glider Test (1 Generation)
        $this->assertEquals([
            [0, 1, 0],
            [0, 0, 1],
            [1, 1, 1]
        ], get_generation([
            [1, 0, 0],
            [0, 1, 1],
            [1, 1, 0]
        ], 1));
    }

    public function test0Gen() {
        // Basic Glider Test (0 Generation)
        $this->assertEquals([
            [1, 0, 0],
            [0, 1, 1],
            [1, 1, 0]
        ], get_generation([
            [1, 0, 0],
            [0, 1, 1],
            [1, 1, 0]
        ], 0));
    }

    public function test2Gen() {
        // Basic Glider Test (2 Generation)
        $this->assertEquals([
            [1, 0, 1],
            [0, 1, 1],
            [0, 1, 0]
        ], get_generation([
            [1, 0, 0],
            [0, 1, 1],
            [1, 1, 0]
        ], 0));
    }
}
$a = new ConwaysGameOfLifeUnlimitedEditionTest();
//$a->testExample();
//$a->test0Gen();
//$a->test2Gen();

$cells = [
    [1, 0, 0],
    [0, 1, 1],
    [1, 1, 0]
];

//for ($y = -1; $y <= count($cells); $y++) {
//    for ($x = -1; $x <= count($cells[0]); $x++) {
for ($y = 0; $y < count($cells); $y++) {
    for ($x = 0; $x < count($cells[0]); $x++) {
        echo count_living_neighbours($cells, $x, $y);
    }
    echo PHP_EOL;
}
echo PHP_EOL;


//
//echo htmlize($cells);
//echo htmlize(get_generation($cells, 1));

//var_dump(get_generation($cells, 1));
