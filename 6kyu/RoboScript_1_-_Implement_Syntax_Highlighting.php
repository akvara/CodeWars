<?php

CONST FOR_NUMBER = 'orange';
CONST FOR_COMMAND = [
    "R" => 'green',
    "L" => 'red',
    "F" => 'pink'
];

function highlight(string $code): string {
    $output = "";
    $prev = "";

    for ($i = 0; $i < strlen($code); $i++) {
        $command = $code[$i];

        close_span_if_needed($command, $prev, $output);

        start_span_if_needed($command, $prev, $output);

        $prev = $command;
    }

    if (!in_array($prev, ["", ")", "("])) close_span($output);

    return $output;
}

function start_span(string $color, string $command, string &$output) {
    $output .= '<span style="color: ' . $color . '">' . $command;
}

function close_span(string &$output) {
    $output .= '</span>';
}

function start_span_if_needed(string $command, string $prev, string &$output)
{
    if (in_array($command, ["R", "L", "F"]) && $command != $prev) {
        start_span(FOR_COMMAND[$command], $command, $output);
        return;
    }

    if (is_numeric($command) && !is_numeric($prev)) {
        start_span(FOR_NUMBER, $command, $output);
        return;
    }

    $output .= $command;
}

function close_span_if_needed(string $command, string $prev, string &$output)
{
    if ($prev === "") return;

    if ($command === $prev) return;

    if (is_numeric($command) && is_numeric($prev)) return;

    if (in_array($prev, ["(", ")"])) return;

    close_span($output);

    return;
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

//echo "Code without syntax highlighting: F3RF5LF7\r\n";
//echo "Expected syntax highlighting: <span style=\"color: pink\">F</span><span style=\"color: orange\">3</span><span style=\"color: green\">R</span><span style=\"color: pink\">F</span><span style=\"color: orange\">5</span><span style=\"color: red\">L</span><span style=\"color: pink\">F</span><span style=\"color: orange\">7</span>\r\n";
//echo "Your code with syntax highlighting: " . highlight("F3RF5LF7") . "\r\n";
assertEquals("<span style=\"color: pink\">F</span><span style=\"color: orange\">3</span><span style=\"color: green\">R</span><span style=\"color: pink\">F</span><span style=\"color: orange\">5</span><span style=\"color: red\">L</span><span style=\"color: pink\">F</span><span style=\"color: orange\">7</span>", highlight("F3RF5LF7"));
//echo "Code without syntax highlighting: FFFR345F2LL\r\n";
//echo "Expected syntax highlighting: <span style=\"color: pink\">FFF</span><span style=\"color: green\">R</span><span style=\"color: orange\">345</span><span style=\"color: pink\">F</span><span style=\"color: orange\">2</span><span style=\"color: red\">LL</span>\r\n";
//echo "Your code with syntax highlighting: " . highlight("FFFR345F2LL") . "\r\n";
assertEquals("<span style=\"color: pink\">FFF</span><span style=\"color: green\">R</span><span style=\"color: orange\">345</span><span style=\"color: pink\">F</span><span style=\"color: orange\">2</span><span style=\"color: red\">LL</span>", highlight("FFFR345F2LL"));
assertEquals("<span style=\"color: green\">RRRRR</span>(<span style=\"color: pink\">F</span><span style=\"color: orange\">45</span><span style=\"color: red\">L</span><span style=\"color: orange\">3</span>)<span style=\"color: pink\">F</span><span style=\"color: orange\">2</span>", highlight("RRRRR(F45L3)F2"));
assertEquals("Expected: '<span style=\"color: orange\">00172</span><span style=\"color: red\">L</span><span style=\"color: orange\">873583</span><span style=\"color: red\">L</span>(<span style=\"color: orange\">26324</span><span style=\"color: pink\">F</span><span style=\"color: orange\">08</span><span style=\"color: green\">R</span><span style=\"color: orange\">14139</span><span style=\"color: green\">R</span><span style=\"color: orange\">20255</span><span style=\"color: red\">L</span>)<span style=\"color: orange\">697</span><span style=\"color: red\">L</span><span style=\"color: orange\">23431</span>('", highlight("00172L873583L(26324F08R14139R20255L)697L23431("));

echo PHP_EOL;
