<?php

function sum_strings($a, $b) {
    $extra = 0;
    $res = '';
    for ($i = 0; $i < max(strlen($a), strlen($b)); $i++) {
        $cur = intval(from_end($a, $i)) + intval(from_end($b, $i)) + $extra;
        $extra = intdiv($cur, 10);
        $res = strval($cur % 10) . $res;
    }
    $res = strval($extra) . $res;
    while ($res[0] === '0') $res = substr($res, 1);
    return $res;
}

function from_end(string $s, int $index):int {
    $pos = strlen($s) - 1 - $index;
    if ($pos < 0) return 0;

    return $s[$pos];
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

assertEquals('579', sum_strings('123', '456'));

echo PHP_EOL;
