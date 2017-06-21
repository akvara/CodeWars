<?php

include_once __DIR__.'/vendor/autoload.php';
use PHPUnit\Framework\TestCase;

function part($n) {
/*
    $prod = [$n];

    for ($i = 1; $i <= intdiv($n, 2); $i++) {
        for ($j = $i; $j <= $n-$i; $j++) {
            $prod[] = $i * $j;
        }
    }
    sort($prod);
*/
    $known[1] = [[1]];
    for ($i = 2; $i <= $n; $i++) {
        $known[$i] = [];
        $tmp = [];
        for ($j = 1; $j <= intdiv($i, 2); $j++) {
            $tmp[] = $j * ($i-$j) ;
        }
        $known[$i][] = $tmp;
    }

    echo "E: " . stringify_array($known) . PHP_EOL;
//    $prod = prod($known[$n]);
//    echo "Easy: " . stringify_array(array_values(array_unique($prod))) . PHP_EOL;


    $known[1] = [[1]];
    for ($i = 2; $i <= $n; $i++) {
        $known[$i] = [];
        $tmp = [];
        for ($j = 1; $j <=intdiv($i ,2); $j++) {
            $tmp = array_merge($tmp, multiply_set($known, $j, $i-$j));
            $tmp = array_map("unserialize", array_unique(array_map("serialize", $tmp )));
        }
        $known[$i] = array_merge($tmp, [[$i]]);
    }
    $prod = prod($known[$n]);

    echo "Hard: " . stringify_array(array_values($prod)) . PHP_EOL;

    return sprintf("Range: %d Average: %01.2f Median: %01.2f", calc_range($prod), ave($prod), median($prod));
}

function multiply_set($known, $a, $b){
    echo "$a x $b" . ", ";
    $res = [];
    foreach ($known[$a] as $set_a) {
        foreach ($known[$b] as $set_b) {
            $tmp = array_merge($set_a, $set_b);
            array_multisort($tmp );
            $res[] = $tmp;
        }
    }
    return $res;
}

function prod($arr) {
    $res = [];

    foreach ($arr as $enum) {
        $prod = 1;
        foreach ($enum as $item) {
            $prod *= $item;
        }
        $res[] = $prod;
    }
    sort($res);
    return array_values(array_unique($res));
}

function calc_range($arr) {
    return max($arr) - min($arr);
}

function ave($arr) {
    return array_sum($arr) / count($arr);
}

function median($arr) {
    $count = count($arr);
    $middleval = floor(($count - 1) / 2);
    if($count % 2) {
        $median = $arr[$middleval];
    } else {
        $low = $arr[$middleval];
        $high = $arr[$middleval + 1];
        $median = (($low + $high) / 2);
    }
    return $median;
}

/*function part($n) {
//    $start = microtime(true);
    $prod = [];
    $known[1] = [[1]];
    for ($i = 2; $i <= $n; $i++) {
        $known[$i] = [];
        $tmp = [];
        for ($j = 1; $j <= intdiv($i, 2); $j++) {
            $prod[] = $j * ($i-$j);
            $tmp = array_merge($tmp, multiply_set($known, $j, $i-$j));
            $tmp = array_map("unserialize", array_unique(array_map("serialize", $tmp)));
        }
        $known[$i] = $tmp;
    }
    $prod = prod($known[$n]);
//    $time_elapsed_secs = microtime(true) - $start;
//    $shout = sprintf("N=%d took %0.f", $n, $time_elapsed_secs);
    sort($prod);
//    $prod = array_values(array_unique($prod));
//    echo stringify_array($prod) . PHP_EOL;
//die;
//    var_dump($shout);

    return sprintf("Range: %d Average: %01.2f Median: %01.2f", calc_range($prod), ave($prod), median($prod));
}

function multiply_set(&$known, $a, $b){
    echo "$a x $b" .PHP_EOL;
    $res = [];
    foreach ($known[$a] as $set_a) {
        foreach ($known[$b] as $set_b) {
            $tmp = array_merge($set_a, $set_b);
//echo stringify_array($tmp) . PHP_EOL;
            array_multisort($tmp);
            $res[] = $tmp;
        }
    }
    return $res;
}

function prod($arr) {
    $res = [];

    foreach ($arr as $enum) {
        $prod = 1;
        foreach ($enum as $item) {
            $prod *= $item;
        }
        $res[] = $prod;
    }
    sort($res);
    return array_values(array_unique($res));
}

function calc_range($arr) {
    return max($arr) - min($arr);
}

function ave($arr) {
    return array_sum($arr) / count($arr);
}

function median($arr) {
    $count = count($arr);
    $middleval = floor(($count - 1) / 2);
    if($count % 2) {
        $median = $arr[$middleval];
    } else {
        $low = $arr[$middleval];
        $high = $arr[$middleval + 1];
        $median = (($low + $high) / 2);
    }
    return $median;
}
*/

// Debug

function stringify_array($arr) {
    $res = "";
    foreach ($arr as $item) {
        if (strlen($res) > 0) $res .= ", ";
        if (is_array($item)) {
            $res .=  stringify_array($item);
        } else {
            $res .= $item;
        }
    }

    return "[" . $res. "]";
}

class IntPartTestCases extends TestCase {
    private function revTest($actual, $expected) {
        $this->assertEquals($expected, $actual);
    }
    public function testPartBasics() {
        $this->revTest(part(1), "Range: 0 Average: 1.00 Median: 1.00");
        $this->revTest(part(2), "Range: 1 Average: 1.50 Median: 1.50");
        $this->revTest(part(3), "Range: 2 Average: 2.00 Median: 2.00");
        $this->revTest(part(4), "Range: 3 Average: 2.50 Median: 2.50");
        $this->revTest(part(5), "Range: 5 Average: 3.50 Median: 3.50");
        $this->revTest(part(6), "Range: 8 Average: 4.75 Median: 4.50");
        $this->revTest(part(7), "Range: 11 Average: 6.09 Median: 6.00");
        $this->revTest(part(8), "Range: 17 Average: 8.29 Median: 6.50");
    }
}

$t = new IntPartTestCases();
//$t->testPartBasics();
//echo stringify_array(part(7)) . PHP_EOL;


part(8);
//part(20);
//part(30);
//part(35);

for ($i = 1; $i <= 10; $i++) {
    echo $i . PHP_EOL;
    part($i);
    echo PHP_EOL;
}