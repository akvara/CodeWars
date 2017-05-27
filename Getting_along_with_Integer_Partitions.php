<?php

include_once __DIR__.'/vendor/autoload.php';
use PHPUnit\Framework\TestCase;

function part($n) {
    $known[1] = [1];
    for ($x = 2; $x <= $n; $x++) {
        $res = [$x];
        $res[] = array_merge([$x - 1], $known[$x - 1]);
        $known[$x] = $res;
    }
    echo stringify_array($known[$n]) . PHP_EOL;
//    [2], [1, 1]
//    [3], [2, 1], [1, 1, 1]
//    [4], [3,1], [2,2], [2,1,1], [1,1,1,1]
//    [5],[4,1],[3,2],[3,1,1],[2,2,1],[2,1,1,1],[1,1,1,1,1]]

//    var_dump($known);
//    $prod = prod($known);
//    var_dump($prod);
//    return sprintf("Range: %d Average: %01.2f Median: %01.2f", calc_range($prod), ave($prod), median($prod));
}

function all_ones($arr) {
    $level1 = $arr;
    echo "0: ". stringify_array($level1) . PHP_EOL;

    for ($i = 1; $i < count($arr); $i++) {
        $level1 = array_slice($level1, 0, count($level1) - 1);
        $level1[0]++;
        echo "1: ". stringify_array($level1) . PHP_EOL;
        $increase_position = 1;
        $level2 = array_slice($level1, 0, count($level1) - 1);
//        echo "level 2: ". stringify_array($level1) . PHP_EOL;

        while ($increase_position < count($level2) && $level2[$increase_position] < $level2[$increase_position - 1]) {
            $level3 = $level2;
            $level3[$increase_position]++;
            echo "3: ". stringify_array($level3) . PHP_EOL;

            while (count($level3) > $increase_position){
                $level3[$increase_position]++;
//                $level3 = array_slice($level3, 0, count($level3) - 1);
//
                echo stringify_array($level3) . PHP_EOL;
//
                $increase_position++;
            }
            $level3 = array_slice($level3, 0, count($level3) - 1);
        }

//
//        for ($j = 1; $j < count($level1)- 2; $j++) {
//            $level2 = array_slice($level1, 0, count($level1) - 1);
//            $level2[$j]++;
//            echo stringify_array($level2) . PHP_EOL;
//        }
    }
}

function prod($arr) {
    $res = 1;
    foreach ($arr as $item) $res *= $item;
    return [$res];
}

function calc_range($arr) {
    return max($arr) - min($arr);
}

function ave($arr) {
    return array_sum($arr) / count($arr);
}

function median($arr) {
    $count = count($arr); //total numbers in array
    $middleval = floor(($count-1)/2); // find the middle value, or the lowest middle value
    if($count % 2) { // odd number, middle is the median
        $median = $arr[$middleval];
    } else { // even number, calculate avg of 2 medians
        $low = $arr[$middleval];
        $high = $arr[$middleval+1];
        $median = (($low+$high)/2);
    }
    return $median;
}

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
//        $this->revTest(part(1), "Range: 0 Average: 1.00 Median: 1.00");
//        $this->revTest(part(2), "Range: 1 Average: 1.50 Median: 1.50");
//        $this->revTest(part(3), "Range: 2 Average: 2.00 Median: 2.00");
//        $this->revTest(part(4), "Range: 3 Average: 2.50 Median: 2.50");
//        $this->revTest(part(5), "Range: 5 Average: 3.50 Median: 3.50");
//        $this->revTest(part(6), "Range: 8 Average: 4.75 Median: 4.50");
//        $this->revTest(part(7), "Range: 11 Average: 6.09 Median: 6.00");
    }
}

$t = new IntPartTestCases();
//$t->testPartBasics();

//part(1);
//part(2);
//part(3);

all_ones([1, 1, 1, 1, 1, 1, 1]);