<?php

include_once __DIR__.'/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;

$MORSE = [
    ' ' => ' ',
    'A' => '.-',
    'B' => '-...',
    'C' => '-.-.',
    'D' => '-..',
    'E' => '.',
    'F' => '..-.',
    'G' => '--.',
    'H' => '....',
    'I' => '..',
    'J' => '.---',
    'K' => '-.-',
    'L' => '.-..',
    'M' => '--',
    'N' => '-.',
    'O' => '---',
    'P' => '.--.',
    'Q' => '--.-',
    'R' => '.-.',
    'S' => '...',
    'T' => '-',
    'U' => '..-',
    'V' => '...-',
    'W' => '.--',
    'X' => '-..-',
    'Y' => '-.--',
    'Z' => '--..',
    '0' => '-----',
    '1' => '.----',
    '2' => '..---',
    '3' => '...--',
    '4' => '....-',
    '5' => '.....',
    '6' => '-....',
    '7' => '--...',
    '8' => '---..',
    '9' => '----.',
    '.' => '.-.-.-',
    ',' => '--..--',
    '?' => '..--..',
    '!' => '-.-.--',
    ':' => '---...',
    "'" => '.----.',
    '"' => '.-..-.',
    '-' => '-....-',
    '/' => '-..-.',
    '(' => '-.--.',
    ')' => '-.--.-',
    'SOS' => '...---...',
];

function decode_morse(string $code): string {
    global $MORSE;
    $out = '';

    $decode = array_flip($MORSE);
    foreach (explode(" ", $code) as $sym) {
        $out .= $sym ? $decode[$sym] : ' ';
    }

    return str_replace('  ', ' ', trim($out));
}


class MyTestCases extends TestCase
{
    public function testBasicCases() {
        $this->assertEquals('HEY JUDE', decode_morse('.... . -.--   .--- ..- -.. .'));
    }
}

$t = new MyTestCases();
$t->testBasicCases();

//array_multisort(array_map('strlen', $MORSE), SORT_DESC, SORT_NUMERIC, $MORSE);
//var_dump($MORSE);