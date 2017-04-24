<?php

include_once __DIR__.'/vendor/autoload.php';
use PHPUnit\Framework\TestCase;

function solution ($roman) {
    $ROMAN = [
        'CM' => 900,
        'CD' => 400,
        'XC' => 90,
        'XL' => 40,
        'IX' => 9,
        'IV' => 4,
        'M' => 1000,
        'D' => 500,
        'C' => 100,
        'L' => 50,
        'X' => 10,
        'V' => 5,
        'I' => 1
    ];

    $number = 0;

    foreach ($ROMAN as $rom => $arab) {
        $number += substr_count ($roman, $rom) * $arab;
        $roman = str_replace($rom, '', $roman);
    }

    return $number;
}

class RomanDecoderTestCases extends TestCase
{
    // test function names should start with "test"
    public function testBasics() {
        $this->assertEquals(1000, solution("M"));
        $this->assertEquals(50, solution("L"));
        $this->assertEquals(4, solution("IV"));
    }

    public function testComplex() {
        $this->assertEquals(2017, solution("MMXVII"));
        $this->assertEquals(1337, solution("MCCCXXXVII"));
    }
}

$t = new RomanDecoderTestCases();
$t->testBasics();
$t->testComplex();

