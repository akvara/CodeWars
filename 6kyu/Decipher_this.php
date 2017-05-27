<?php

include_once __DIR__.'/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;

function decipherThis($str){
    $arr = explode(' ', $str);
    $res = [];
    foreach ($arr as $word) {
        $decoded = intval($word);
        $remain  = substr($word, strlen($decoded));
        $decoded = chr($decoded);
        if (strlen($remain) > 0) {
            $decoded .=
                (strlen($remain) > 1 ? $remain[strlen($remain) - 1] : '')
                . substr($remain, 1, strlen($remain) - 2)
                . $remain[0];
        }
        $res[] = $decoded;
    }
    return implode($res, ' ');
}


class MyTestCases extends TestCase
{
    public function testThatSomethingShouldHappen() {
        $this->assertEquals(decipherThis('72olle 103doo 100ya'), 'Hello good day');
        $this->assertEquals(decipherThis('82yade 115te 103o'), 'Ready set go');
    }
}

$t = new MyTestCases();
//$t->testThatSomethingShouldHappen();

var_dump(decipherThis('72'));
