<?php

function revRot($s, $sz) {
    if ($sz <= 0 || $s == "" ) return "";
    $rem = $s;
    $res = '';
    $chunk = substr($rem, 0, $sz);
    $rem = substr($rem, $sz);
    while (strlen($chunk) >= $sz) {
        $res .= (sum_of_the_cubes_of_its_digits_is_divisible_by_2($chunk))  ? rev($chunk) : rot($chunk);
        $chunk = substr($rem, 0, $sz);
        $rem = substr($rem, $sz);
    }
    return $res;
}

function sum_of_the_cubes_of_its_digits_is_divisible_by_2($s) {
    $sum = 0;
    for ($i = 0; $i < strlen($s); $i++) {
        $sum += intval($s[$i])**3;
    }
    return $sum % 2 === 0;
}

function rev($s) {
    $res = '';
    for ($i = 0; $i < strlen($s); $i++) {
        $res .= $s[strlen($s) - $i - 1];
    }
    return $res;
}

function rot($s) {
    return substr($s, 1) . $s[0];
}