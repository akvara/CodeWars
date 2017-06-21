<?php

$start = microtime(true);

//...

$time_elapsed_secs = microtime(true) - $start;
if($time_elapsed_secs > 4) {
    $shout = sprintf("N=%d %0.f;", $n, $time_elapsed_secs) . PHP_EOL;
    echo ($shout);
    die;
}