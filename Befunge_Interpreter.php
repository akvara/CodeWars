<?php

const DIRECTION = "<>^v";
const TWO_OPERANDS = "+-*/%`";
const ONE_OPERAND = "!";

function main_logic(
    string $current,
    stdClass &$carret,
    array &$stack,
    string &$direction,
    bool &$string_mode,
    array &$matrix,
    string &$output
) {
    if ($current === '"') {
        $string_mode = !$string_mode;
        return;
    }

    if ($string_mode) {
        array_push($stack, ord($current));
        return;
    }

    if (strpos(DIRECTION, $current) !== false) {
        $direction = $current;
        return;
    }

    if ($current === '?') {
        $direction = DIRECTION[rand(0, 3)];
        return;
    }

    if (strpos(TWO_OPERANDS, $current) !== false) {
        two_operands($stack, $current);
        return;
    }

    if (strpos(ONE_OPERAND, $current) !== false) {
        one_operand($stack, $current);
        return;
    }

    if (is_numeric($current)) {
        array_push($stack, intval($current));
        return;
    }

    if ($current === '_') {
        $direction = array_pop($stack) === 0 ? '>' : '<';
        return;
    }

    if ($current === '|') {
        $direction = array_pop($stack) === 0 ? 'v' : '^';
        return;
    }

    if ($current === '$') {
        array_pop($stack);
        return;
    }

    if ($current === '\\') {
        $a = array_pop($stack);
        $b = count($stack) > 0 ? array_pop($stack) : 0;
        array_push($stack, $a);
        array_push($stack, $b);
        return;
    }

    if ($current === '.') {
        $output .= array_pop($stack);
        return;
    }

    if ($current === ':') {
        if (count($stack) === 0) {
            array_push($stack, 0);
            return;
        }
        $top = array_pop($stack);
        array_push($stack, $top);
        array_push($stack, $top);
        return;
    }

    if ($current === ',') {
        $output .= chr(array_pop($stack));
        return;
    }

    if ($current === '#') {
        $carret = move($carret, $direction, $matrix);
        return;
    }

    if ($current === ' ') {
        return;
    }

    if ($current === 'p') {
        $y = array_pop($stack);
        $x = array_pop($stack);
        $v = array_pop($stack);
        $matrix[$y][$x] = chr($v);
        return;
    }

    if ($current === 'g') {
        $y = array_pop($stack);
        $x = array_pop($stack);
        array_push($stack, ord($matrix[$y][$x]));
        return;
    }

    echo "Unimplemented operation:" . $current . PHP_EOL .PHP_EOL;
    exit;
}

function make2d(string $code): array {
    $res = [];
    foreach (explode("\n", $code) as $row) {
        $res[] = str_split($row);
    }
    return $res;
}

function two_operands(array &$stack, string $op) {
    $a = array_pop($stack);
    $b = array_pop($stack);
    switch($op){
        case "*":
            array_push($stack, $a * $b);
            break;
        case "+";
            array_push($stack, $a + $b);
            break;
        case "-";
            array_push($stack, $b - $a);
            break;
        case "/";
            array_push($stack, intdiv($b, $a));
            break;
        case "%";
            array_push($stack, $b % $a);
            break;
        case "`";
            array_push($stack, $b > $a ? 1 : 0);
            break;
    }
}

function one_operand(array &$stack, string $op) {
    $a = array_pop($stack);

    switch($op){
        case "!";
            array_push($stack, $a === 0 ? 1 : 0);
            break;
    }
}

function move(stdClass $carret, string $direction, array $matrix): stdClass {
    switch ($direction) {
        case '>':
            if ($carret->X < count($matrix[$carret->Y]) - 1) $carret->X++;
            break;
        case '<':
            if ($carret->X > 0) $carret->X--;
            break;
        case '^':
            if ($carret->Y > 0) $carret->Y--;
            break;
        case 'v':
            if ($carret->Y < count($matrix) - 1) $carret->Y++;
            break;
    }
    return $carret;
}

function interpret(string $code): string {
    $output = "";
    $stack = [];
    $direction = '>';
    $matrix = make2d($code);
    $carret = (object) [
        'X' => 0,
        'Y' => 0
    ];
    $current = $matrix[0][0];
    $string_mode = false;

    while ($current !== "@") {
        main_logic($current, $carret, $stack, $direction, $string_mode, $matrix, $output);

        $carret = move($carret, $direction, $matrix);
        $current = $matrix[$carret->Y][$carret->X];
    }

    return $output;
}


// ***** Debug *****

function step_by_step(string $code, $auto = false): string {
    $output = "";
    $stack = [];
    $direction = '>';
    $matrix = make2d($code);
    $carret = (object) [
        'X' => 0,
        'Y' => 0
    ];
    $current = $matrix[0][0];
    $string_mode = false;
    $step = 0;
    $handle = fopen ("php://stdin","r");

    while ($current !== "@") {
        print_matrix($matrix, $carret);
        echo "Step: " . $step .  PHP_EOL;
        echo "y, x: " . $carret->Y . " " . $carret->X .  PHP_EOL;
        echo "Char: " . $matrix[$carret->Y][$carret->X] .  PHP_EOL;
        print_stack($stack);
        echo "Output: '" . $output . "'";
        if ($step > 115) $auto = false;
        if ($auto) usleep(300000); else fgets($handle);
        main_logic($current, $carret, $stack, $direction, $string_mode, $matrix, $output);

        $carret = move($carret, $direction, $matrix);
        $current = $matrix[$carret->Y][$carret->X];
        $step++;
    }

    fclose($handle);

    return $output;
}

function isXY(stdClass $a, $x, $y) {
    return $a->X === $x && $a->Y === $y;
}

function print_matrix(array $matrix, stdClass $pos = null) {
    passthru('clear');
    $y = 0;
    foreach ($matrix as $row) {
        $x = 0;
        echo "'";
        foreach ($row as $char) {
            if ($pos && $pos->X === $x && $pos->Y === $y) {
                echo sprintf("\033[01;31m%s\033[0m", $char);
            } else {
                echo $char;
            }
            $x++;
        }
        $y++;
        echo "'";
        echo PHP_EOL;
    }
    echo "-----PHP-----" . PHP_EOL;
}

function print_stack(array $stack) {
    echo "Stack: [" .  implode($stack, ', ') . "]" . PHP_EOL;
}

// ***** Tests *****

function check(stdClass $a, $x, $y) {
    echo isXY($a, $x, $y) ? "." :  "\033[01;31m!\033[0m";
}

function compare(string $a, string $b) {
    echo $a === $b ? "." : "\033[01;31m!\033[0m";
    return $a === $b;
}

function unit_test_move()
{
    echo "Unit test - move:";
    $carret = (object)[
        'X' => 0,
        'Y' => 0
    ];

    $matrix = [
        [' ', ' ', ' ', ' '],
        [' ', ' ', ' ', ' ', ' ']
    ];

    // down, 'v'
    check(move($carret, 'v', $matrix), 0, 1);
    check(move($carret, 'v', $matrix), 0, 1);

    // up, '^'
    check(move($carret, '^', $matrix), 0, 0);
    check(move($carret, '^', $matrix), 0, 0);


    // right, '>'
    check(move($carret, '>', $matrix), 1, 0);
    check(move($carret, '>', $matrix), 2, 0);
    check(move($carret, '>', $matrix), 3, 0);
    check(move($carret, '>', $matrix), 3, 0);

    // left, '<'
    check(move($carret, '<', $matrix), 2, 0);
    check(move($carret, '<', $matrix), 1, 0);
    check(move($carret, '<', $matrix), 0, 0);
    check(move($carret, '<', $matrix), 0, 0);

    // appendix, '>'
    check(move($carret, '>', $matrix), 1, 0);
    check(move($carret, '>', $matrix), 2, 0);
    check(move($carret, '>', $matrix), 3, 0);
    check(move($carret, '>', $matrix), 3, 0);
    check(move($carret, 'v', $matrix), 3, 1);
    check(move($carret, 'v', $matrix), 3, 1);
    check(move($carret, '>', $matrix), 4, 1);
    check(move($carret, '>', $matrix), 4, 1);
    echo PHP_EOL;

}


function funct_test_several() {
    $cases = [];
    $i = 0;

    $inp = <<<"EOD"
08>:1-:v v *_$.@
  ^    _$>\:^
EOD;
    $out = '40320';
    $cases[] = [$inp, $out];

    $inp = '64+"!dlroW ,olleH">:#,_@';
    $out = "Hello, World!\n";
    $cases[] = [$inp, $out];

    // Put / get
    $inp = '>89*35*0p53*0g"X",@';
    $out = "H";
    $cases[] = [$inp, $out];

    // String mode
    $inp = '>"!olle"89*,,,,,,@';
    $out = "Hello!";
    $cases[] = [$inp, $out];

    // Code wars
    $inp = ">987v>.v\nv456<  :\n>321 ^ _@";
    $out = "123456789";
    $cases[] = [$inp, $out];

    //
    $inp = <<<"EOD"
>25*"!dlrow ,olleH":v
                 v:,_@
                 >  ^
EOD;
    $out = "Hello, world!\n";
    $cases[] = [$inp, $out];

    //
    $inp = <<<"EOD"
>              v
v  ,,,,,"Hello"<
>48*,          v
v,,,,,,"World!"<
>25*,@
EOD;
    $out = "Hello World!\n";
    $cases[] = [$inp, $out];

    // Quine
    $inp = "01->1# +# :# 0# g# ,# :# 5# 8# *# 4# +# -# _@";
    $out = "01->1# +# :# 0# g# ,# :# 5# 8# *# 4# +# -# _@";
    $cases[] = [$inp, $out];

    // Factorial: no &
//    $inp = <<<"EOD"
//&>:1-:v v *_$.@
// ^    _$>\:^
//EOD;
//    $out = "?";
//    $cases[] = [$inp, $out];

    // DNA-code
//    $inp = <<<"EOD"
//>78*vD
//v$_#>vN
//7#!@  A
//3 :v??v
//9,-""""
//4+1ACGT
//+,,""""
//>^^<<<<
//EOD;
//    $out = "?";
//    $cases[] = [$inp, $out];


    // Sieve of Eratosthenes
    $inp = <<<"EOD"
2>:3g" "-!v\  g30          <
 |!`"O":+1_:.:03p>03g+:"O"`|
 @               ^  p3\" ":<
2 234567890123456789012345678901234567890123456789012345678901234567890123456789
EOD;

//2>:3g" "-!v\  g30          <
// |!`"&":+1_:.:03p>03g+:"&"`|
// @               ^  p3\" ":<
//2 2345678901234567890123456789012345678
//EOD;
    $out = "2357111317192329313741434753596167717379";
    $cases[] = [$inp, $out];


    foreach ($cases as $test) {
        $res = interpret($test[0]);
        if (!compare($res, $test[1])) {
            echo PHP_EOL . sprintf("Expected '%s, got '%s'", $test[1],$res) . PHP_EOL;
            echo "Startin step-bystep mode " . PHP_EOL;
//            step_by_step($test[0]);
            break;
        }
        $i++;
    }
    echo sprintf("\n%d cases OK.\n\n", $i);
}

// ***** Only here the code comes *****

unit_test_move();
funct_test_several();

$inp = <<<"EOD"
2>:3g" "-!v\  g30          <
 |!`"O":+1_:.:03p>03g+:"O"`|
 @               ^  p3\" ":<
2 234567890123456789012345678901234567890123456789012345678901234567890123456789
EOD;
step_by_step($inp, true);
