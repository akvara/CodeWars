<?php

include_once __DIR__.'/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;

function duplicate_encode($word){
    $counts = array_count_values(str_split(strtoupper($word)));
    $res = '';
    for ($i = 0; $i < strlen($word); $i++) $res .= $counts[strtoupper($word[$i])] > 1 ? ")" : "(";
    return $res;
}


class MyTestCases extends TestCase
{
    public function testBasics() {
        $this->assertEquals(duplicate_encode('din'), '(((');
        $this->assertEquals(duplicate_encode('recede'), '()()()');
        $this->assertEquals(duplicate_encode('Success'), ')())())', 'should ignore case');
        $this->assertEquals(duplicate_encode('iiiiii'), '))))))', 'duplicate-only-string');
        $this->assertEquals(duplicate_encode(' ( ( )'), ')))))(');
    }
}

$t = new MyTestCases();
$t->testBasics();
