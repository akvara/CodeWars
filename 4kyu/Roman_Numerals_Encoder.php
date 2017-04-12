<?php

function solution($number)
{
    $ROMAN = [
        '1000' => 'M',
        '900' => 'CM',
        '500' => 'D',
        '400' => 'CD',
        '100' => 'C',
        '90' => 'XC',
        '50' => 'L',
        '40' => 'XL',
        '10' => 'X',
        '9' => 'IX',
        '5' => 'V',
        '4' => 'IV',
        '1' => 'I'
    ];

    $out = '';

    $arabian = key($ROMAN);
    $roman = current($ROMAN);

    while ($number > 0) {
        if ($number >= $arabian) {
            $number -= $arabian;
            $out .= $roman;
        } else { // get lower number
            next($ROMAN);
            $arabian = key($ROMAN);
            $roman = current($ROMAN);
        }
    }

    return $out;
}


// ***** Unit tests *****

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

assertEquals("M", solution(1000));
assertEquals("IV", solution(4));
assertEquals("I", solution(1));
assertEquals("MCMXC", solution(1990));
assertEquals("MMVIII", solution(2008));

echo PHP_EOL;
