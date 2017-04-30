<?php

include_once __DIR__.'/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;

function reverseParentheses($s) {
    $tmp = [];
    $res = '';
    $i = 0;
    while ($i < strlen($s)) {
        if ($s[$i] === "(") {
            array_push($tmp, $res);
            $res = '';
        } elseif ($s[$i] === ")") {
            $res = array_pop($tmp) . strrev($res);
        } else {
            $res .= $s[$i];
        }
        $i++;
    }
    return $res;
}

class MyTestCases extends TestCase
{
    // test function names should start with "test"
    public function testThatSomethingShouldHappen() {
        $this->assertEquals("acbde", reverseParentheses("a(bc)de"));
        $this->assertEquals("apmnolkjihgfedcbq", reverseParentheses("a(bcdefghijkl(mno)p)q"));
        $this->assertEquals("coswared", reverseParentheses("co(de(war)s)"));
        $this->assertEquals("CodeegnlleahC", reverseParentheses("Code(Cha(lle)nge)"));

    }
}

$t = new MyTestCases();
$t->testThatSomethingShouldHappen();
