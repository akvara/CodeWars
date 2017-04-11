<?php

const DIRECTIONS = 'RDLU';

function execute(string $input): string
{
    $direction = "R";

    $carret = (object) [
        'X' => 0,
        'Y' => 0
    ];
    $field = ["*"];
    $repeat = 0;
    $prev = "";

    for ($i = 0; $i < strlen($input); $i++) {
        $command = $input[$i];
        if (in_array($command, ["R", "L", "F"])) {
            repeater($repeat, $prev, $field, $direction, $carret);
            $prev = $command;

            continue;
        }

        if (is_numeric($command)) {
            $repeat = $repeat * 10 + intval($command);
            continue;
        }

    }
    repeater($repeat, $prev, $field, $direction, $carret);

    return transform($field);
}

function repeater(int &$repeat, string $command, array &$field, string &$direction, stdClass &$carret) {
    if (!$repeat) commander($command, $field, $direction, $carret);

    for ($r = 1; $r <= $repeat; $r++) {
        commander($command, $field, $direction, $carret);
    }

    $repeat = 0;
}

function commander(string $command, array &$field, string &$direction, stdClass &$carret) {
    if (in_array($command, ["R", "L"])) {
        $direction = rotate($command, $direction);
        return;
    }

    if ($command === "F") {
        advance($direction, $field, $carret);
        return;
    }
}

function rotate($which, $current): string {
    $ind = strpos(DIRECTIONS, $current) + ($which === "L" ? -1 : 1);

    if($ind < 0) $ind = strlen(DIRECTIONS) - 1;
    if($ind === strlen(DIRECTIONS)) $ind = 0;

    return DIRECTIONS[$ind];
}

function imprint(int $x, int $y, array &$field) {
    $field[$y] = substr_replace($field[$y], '*', $x, 1);
}

function advance(string $direction, array &$field, stdClass &$carret)
{
    switch ($direction) {
        case 'L':
            if ($carret->X === 0) {
                expand_left($field);
            } else {
                $carret->X--;
            }
            break;
        case 'R':
            $carret->X++;
            if ($carret->X >= strlen($field[0])) expand_right($field);
        break;
        case 'U':
            if ($carret->Y===0) {
                expand_up($field);
            } else {
                $carret->Y--;
            }
        break;
        case 'D':
            $carret->Y++;
            if ($carret->Y >= count($field)) expand_down($field);
        break;
    }

    imprint($carret->X, $carret->Y, $field);
}

function expand_left(&$field)
{
    for ($j = 0; $j < count($field); $j++) $field[$j] = ' ' . $field[$j];
}

function expand_right(&$field)
{
    for ($j = 0; $j < count($field); $j++) {
        $field[$j] = $field[$j] . ' ';
    }
}

function expand_up(&$field)
{
    $field = array_merge([str_pad ('', strlen($field[0]))], $field);
}

function expand_down(&$field)
{
    $field[] = str_pad ('', strlen($field[0]));
}

function transform(array $field):string
{
    $output = "";
    for ($j = 0; $j < count($field); $j++) {
        $output .= (strlen($output) > 0 ? "\r\n": "") . $field[$j];
    }
    return $output;
}


// ***** Tests *****

function print_field(array $field)
{
    echo PHP_EOL;
    for ($j = 0; $j < count($field); $j++) {
        echo "'" . $field[$j] . "'" . PHP_EOL;
    }
    echo PHP_EOL;
}

function assertEquals($expect, $var) {
    if ($var === $expect) {
        echo ".";

        return true;
    }
    echo "\033[01;31m!\033[0m" . PHP_EOL;
    echo "---Expected---" . PHP_EOL;
    echo $expect . PHP_EOL;
    echo "-----Got------" . PHP_EOL;
    echo $var . PHP_EOL;

    return false;
}

// ***** Unit tests *****
assertEquals('U', rotate('L', 'R'));
assertEquals('L', rotate('L', 'U'));
assertEquals('D', rotate('L', 'L'));
assertEquals('R', rotate('L', 'D'));

assertEquals('D', rotate('R', 'R'));
assertEquals('L', rotate('R', 'D'));
assertEquals('U', rotate('R', 'L'));
assertEquals('R', rotate('R', 'U'));

$field = [' '];
expand_up($field);
assertEquals(2, count($field));

expand_down($field);
assertEquals(3, count($field));

expand_left($field);
assertEquals(2, strlen($field[2]));

expand_right($field);
assertEquals(3, strlen($field[2]));

imprint(2, 2, $field);
assertEquals('  *', $field[2]);

// ***** Functional *****

assertEquals("*", execute(""));
assertEquals("******\r\n*    *\r\n*    *\r\n*    *\r\n*    *\r\n******", execute("FFFFFLFFFFFLFFFFFLFFFFFL"));
assertEquals("    ****\r\n    *  *\r\n    *  *\r\n********\r\n    *   \r\n    *   ", execute("LFFFFFRFFFRFFFRFFFFFFF"));
assertEquals("    ****\r\n    *  *\r\n    *  *\r\n********\r\n    *   \r\n    *   ", execute("LF5RF3RF3RF7"));

echo PHP_EOL;
