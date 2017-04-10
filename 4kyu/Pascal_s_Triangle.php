<?php

function pascals_triangle($n) {
    $res = null;
    for ($i = 0; $i < $n; $i++) {
        $res[] = get_row($res[$i-1]);
    }
    $out = [];
    for ($row = 0; $row < count($res); $row++) {
        for ($i = 0; $i < count($res[$row]); $i++) {
            $out[] =  $res[$row][$i];
        }
    }
    return $out;
}

function get_row($prev) {
    $res = [1];
    if (!$prev) return $res;
    for ($i = 1; $i < count($prev); $i++) {
        $res[] = $prev[$i - 1] + $prev[$i];
    }
    $res[] = 1;
    return $res;
}