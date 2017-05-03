<?php

include_once __DIR__.'/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;

function find_uniq($a) {
    return array_flip(array_count_values(array_map("strval", $a)))[1] + 0;
}

class FindUniqTest extends TestCase {
    public function testExamples() {
        $this->assertEquals(2, find_uniq([1, 1, 1, 2, 1, 1]));
        $this->assertEquals(0.55, find_uniq([0, 0, 0.55, 0, 0]));
        $this->assertEquals(1, find_uniq([0, 1, 0]));
    }
}

$t = new FindUniqTest();
$t->testExamples();

/* Clever
function find_uniq($a) {
  sort($a);
  return $a[0] == $a[1] ? end($a) : $a[0];
}
 */
