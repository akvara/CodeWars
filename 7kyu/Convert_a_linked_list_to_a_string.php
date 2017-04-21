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

function stringify($list): string {
    if ($list === null) return "NULL";
    return $list->data . " -> " . stringify($list->next);
}

class StringifyTest extends TestCase {
    public function testDescriptionExamples() {
        $this->assertEquals("1 -> 2 -> 3 -> NULL", stringify(new Node(1, new Node(2, new Node(3)))));
        $this->assertEquals("0 -> 1 -> 4 -> 9 -> 16 -> NULL", stringify(new Node(0, new Node(1, new Node(4, new Node(9, new Node(16)))))));
        $this->assertEquals("NULL", stringify(NULL));
    }
}

$t = new StringifyTest();
$t->testDescriptionExamples();
