<?php

include_once __DIR__.'/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;

class Node {
    public $data, $next;
    public function __construct($data, $next = NULL) {
        $this->data = $data;
        $this->next = $next;
    }
}

function count_if($head, $p) {
    $res = 0;
    while ($head) {
        if ($p($head->data)) $res++;
        $head = $head->next;
    }

    return $res;
}

class CountIfTest extends TestCase {
    public function testExamples() {
        $this->assertEquals(0, count_if(NULL, function ($x) {return false;})); // NULL
        $this->assertEquals(3, count_if(new Node(1, new Node(2, new Node(3))), function ($x) {return true;})); // 1 -> 2 -> 3
        $this->assertEquals(2, count_if(new Node(1, new Node(2, new Node(3))), function ($x) {return $x <= 2;})); // 1 -> 2 -> 3
    }
}

$t = new CountIfTest();
$t->testExamples();
