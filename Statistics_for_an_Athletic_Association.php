<?php

function statAssoc($strg)
{
    if (!strlen($strg)) return "";

    preg_match_all("/(\d+\|\d+\|\d+)/", $strg, $matches);

    $all_data = [];

    foreach ($matches[1] as $data) {
        preg_match_all("/(\d+)\|(\d+)\|(\d+)/", $data, $times);
        $all_data[] = time_in_secs($times[1][0], $times[2][0], $times[3][0]);
        var_dump(    formatted(time_in_secs($times[1][0], $times[2][0], $times[3][0])));
    }
    sort($all_data);

    return sprintf(
        "Range: %s Average: %s Median: %s",
        formatted(time_range($all_data[0], $all_data[count($all_data)- 1])),
        formatted(mean($all_data)),
        formatted(median($all_data))
    );
}

function time_in_secs($h, $m, $s) {
    return ($h * 60 + $m) * 60 + $s;
}

function time_range($from, $to) {
    return $to - $from;
}

function mean($arr) {
    return array_sum($arr) / count($arr);
}

function median($arr) {
    return mean(array_slice($arr, intval((count($arr) - 1 )/2), count($arr) % 2 ? 1 : 2));
}

function formatted($time) {
    $h = intdiv($time, 3600);
    $rem = intval($time) - $h * 3600;
    $m = intdiv($rem, 60);
    $s = $rem - $m * 60;

    return  sprintf('%02d|%02d|%02d', $h, $m, $s);
}

var_dump(statAssoc("01|15|59, 1|47|16, 01|17|20, 1|32|34, 2|17|17"));