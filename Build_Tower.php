<?php

function tower_builder(int $n): array {
    $res = [];
    for ($i = 1; $i <= $n; $i++) {
        $res[] = build_row($i, $n);
    }
    return $res;
}

function build_row(int $row, int $of) {
    return str_pad(str_pad("", $row * 2 - 1, "*", STR_PAD_BOTH), $of * 2 - 1, " ", STR_PAD_BOTH);
}