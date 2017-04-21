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

function parse(string $string) {
    $arr = explode(' -> ', $string);
    return p($arr);
}

function p(array $arr) {
    if ($arr[0] === 'NULL') return null;
    $val = array_shift($arr);
    return new Node(abs($val), p($arr));
}

class ParseTest extends TestCase {
    public function testDescriptionExamples() {
        $this->assertEquals(new Node(1, new Node(2, new Node(3))), parse("1 -> 2 -> 3 -> NULL"));
        $this->assertEquals(new Node(0, new Node(1, new Node(4, new Node(9, new Node(16))))), parse("0 -> 1 -> 4 -> 9 -> 16 -> NULL"));
        $this->assertNull(parse("NULL"));
    }
}

$t = new ParseTest();
$t->testDescriptionExamples();
