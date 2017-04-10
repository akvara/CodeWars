<?php

function u($n): array {
    $arr = [0, 1, 1];

    for ($i = 3; $i <= $n; $i++) {
        $arr[$i]  = $arr[$i - $arr[$i - 1]] + $arr[$i - $arr[$i - 2]];
    }

    return $arr;
}

function lengthSupUK($n, $k): int {
    if ($n <= 2) return 0;
    if ($k <= 2) return 0;

    $l = 0;
    $u = u(max($n, $k));

    for ($i = 1; $i <= $n; $i++) {
        if ($u[$i] >= $k) $l++;
    }

    return $l;
}

function comp($n): int {
    if ($n <= 2) return 0;

    $l = 0;
    $u = u($n);

    for ($i = 1; $i <= $n; $i++) {
        if ($u[$i] < $u[$i -1]) $l++;
    }

    return $l;
}


// ***** Tests *****

function check($var, $expect) {
    echo ($var === $expect) ? "." :  "\033[01;31m!\033[0m";
}

check(lengthSupUK(23, 12), 4);
check(lengthSupUK(50, 10), 35);
check(lengthSupUK(500, 100), 304);

check(comp(23), 1); // (since only u(16) < u(15))
check(comp(100), 22);
check(comp(200), 63);

echo PHP_EOL;
