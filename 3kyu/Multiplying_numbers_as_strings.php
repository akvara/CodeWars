<?php

function multiply(string $a, string $b): string {
    $res = '0';
    $ending = '';
    $a = strip_zeros($a);
    $b = strip_zeros($b);

    for ($j = 0; $j < strlen($b); $j++) {
        $extra = 0;
        $temp = '';
        for ($i = 0; $i < strlen($a); $i++) {
            $cur = intval(from_end($a, $i)) * intval(from_end($b, $j)) + $extra;
            $extra = intdiv($cur, 10);
            $temp = strval($cur % 10) . $temp;
        }
        $temp = strval($extra) . $temp . $ending;
        $res = sum_strings($res, $temp);
        $ending .= '0';
    }

    return strip_zeros($res);
}

function sum_strings($a, $b) {
    $extra = 0;
    $res = '';
    for ($i = 0; $i < max(strlen($a), strlen($b)); $i++) {
        $cur = intval(from_end($a, $i)) + intval(from_end($b, $i)) + $extra;
        $extra = intdiv($cur, 10);
        $res = strval($cur % 10) . $res;
    }
    $res = strval($extra) . $res;

    return strip_zeros($res);
}

function from_end(string $s, int $index):int {
    $pos = strlen($s) - 1 - $index;
    if ($pos < 0) return 0;

    return $s[$pos];
}

function strip_zeros($res) {
    while ($res[0] === '0' && strlen($res) > 1) $res = substr($res, 1);

    return $res;
}

// ***** Tests *****

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

// ***** Functional *****

assertEquals("6", multiply("2", "3"));
assertEquals("2070", multiply("30", "69"));
assertEquals("935", multiply("11", "85"));
assertEquals("0", multiply("2", "0"));
assertEquals("0", multiply("0", "30"));
assertEquals("3", multiply("0000001", "3"));
assertEquals("3027", multiply("1009", "03"));
assertEquals("5619135910", multiply("98765", "56894"));
assertEquals("2830869077153280552556547081187254342445169156730", multiply("1020303004875647366210", "2774537626200857473632627613"));
assertEquals("444625839871840560024489175424316205566214109298", multiply("58608473622772837728372827", "7586374672263726736374"));
assertEquals("81129638414606663681390495662081", multiply("9007199254740991", "9007199254740991"));

echo PHP_EOL;
