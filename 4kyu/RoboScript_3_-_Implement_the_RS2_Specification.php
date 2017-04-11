<?php

const DIRECTIONS = 'RDLU';
const COMMANDS = 'RLF';

function execute(string $input): string
{
    $direction = "R";

    $carret = (object) [
        'X' => 0,
        'Y' => 0
    ];
    $field = ["*"];
    $commands = read_block($input);

    for ($i = 0; $i < strlen($commands); $i++) {
        commander($commands[$i], $field, $direction, $carret);
    }

    return transform($field);
}

function read_block(string $input): string {
    if (strlen($input) === 0) return '';

    if (strpos(COMMANDS, $input[0]) !== false) {
        $index = 1;
        $rep = read_repeat($input, $index);
        $out = '';
        for ($i = 1; $i <= $rep; $i++) {
            $out .= $input[0];
        }

        return $out . read_block(substr($input, $index));
    }

    if ($input[0] === '(') {
        $end = find_closing_brackets(substr($input, 1));
        $index = $end + 2;
        $rep = read_repeat($input, $index);
        $str = read_block(substr($input, 1, $index));
        $out = '';
        for ($i = 1; $i <= $rep; $i++) {
            $out .= $str;
        }

        return $out . read_block(substr($input, $index));
    }
    return '';
}

function find_closing_brackets($input) {
    $open = 1;
    $i = 0;
    while ($i < strlen($input)) {
        if ($input[$i] === '(') {
            $open++;
        }
        if ($input[$i] === ')') {
            $open--;
            if ($open === 0) return $i;
        }
        $i++;
    }
    return null;
}

function read_repeat(string $input, int &$index):string {
    if ($index >= strlen($input) || !is_numeric($input[$index])) return 1;

    $rep = 0;
    while ($index < strlen($input) && is_numeric($input[$index])) {
        $rep = $rep * 10 + $input[$index];
        $index++;
    }
    return $rep;
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

function assertInstructionIs(string $expectCommand, int $expectRepeat, Instruction $var) {
    if ($var->command === $expectCommand && $var->repeat === $expectRepeat) {
        echo ".";
        return true;
    }

    echo "\033[01;31m!\033[0m" . PHP_EOL;
    echo "---Expected---" . PHP_EOL;
    echo  "$expectCommand$expectRepeat" . PHP_EOL;
    echo "-----Got------" . PHP_EOL;
    echo  "$var->command$var->repeat" . PHP_EOL;

    return false;
}

// ***** Unit tests *****

function test_rotate()
{
    assertEquals('U', rotate('L', 'R'));
    assertEquals('L', rotate('L', 'U'));
    assertEquals('D', rotate('L', 'L'));
    assertEquals('R', rotate('L', 'D'));

    assertEquals('D', rotate('R', 'R'));
    assertEquals('L', rotate('R', 'D'));
    assertEquals('U', rotate('R', 'L'));
    assertEquals('R', rotate('R', 'U'));
}

function test_expand()
{
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
}


function test_read_instructions() {
    $index = 0;
    $input = "L";
    assertInstructionIs("L", 1, read_instruction($input, $index));

    $index = 0;
    $input = "L1";
    assertInstructionIs("L", 1, read_instruction($input, $index));

    $index = 0;
    $input = "L2";
    assertInstructionIs("L", 2, read_instruction($input, $index));

    $index = 0;
    $input = "L52";
    assertInstructionIs("L", 52, read_instruction($input, $index));

    $index = 3;
    $input = "L52R";
    assertInstructionIs("R", 1, read_instruction($input, $index));

    $index = 0;
    $input = "(L)";
    assertInstructionIs("L", 1, read_instruction($input, $index));

    $index = 0;
    $input = "(L)1";
    assertInstructionIs("L", 1, read_instruction($input, $index));

    $index = 0;
    $input = "(L1)";
    assertInstructionIs("L", 1, read_instruction($input, $index));

    $index = 0;
    $input = "(L1)";
    assertInstructionIs("L", 1, read_instruction($input, $index));
}

test_rotate();
test_expand();

// ***** Functional *****

assertEquals("*", execute(""));
assertEquals("******\r\n*    *\r\n*    *\r\n*    *\r\n*    *\r\n******", execute("FFFFFLFFFFFLFFFFFLFFFFFL"));
assertEquals("    ****\r\n    *  *\r\n    *  *\r\n********\r\n    *   \r\n    *   ", execute("LFFFFFRFFFRFFFRFFFFFFF"));
assertEquals("    ****\r\n    *  *\r\n    *  *\r\n********\r\n    *   \r\n    *   ", execute("LF5RF3RF3RF7"));
assertEquals("    *****   *****   *****\r\n    *   *   *   *   *   *\r\n    *   *   *   *   *   *\r\n    *   *   *   *   *   *\r\n*****   *****   *****   *", execute("F4LF4RF4RF4LF4LF4RF4RF4LF4LF4RF4RF4"));
assertEquals("    *****   *****   *****\r\n    *   *   *   *   *   *\r\n    *   *   *   *   *   *\r\n    *   *   *   *   *   *\r\n*****   *****   *****   *", execute("F4L(F4RF4RF4LF4L)2F4RF4RF4"));
assertEquals("    *****   *****   *****\r\n    *   *   *   *   *   *\r\n    *   *   *   *   *   *\r\n    *   *   *   *   *   *\r\n*****   *****   *****   *", execute("F4L((F4R)2(F4L)2)2(F4R)2F4"));

echo PHP_EOL;

//$input = "F15RF3L";

//$input = "(R(F5))5";

//echo read_input($input);

//echo read_block($input);

