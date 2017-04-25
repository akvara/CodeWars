<?php

include_once __DIR__.'/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;

function solution($str) {
    if ($str === '') return null;
    if (strlen($str) === 1) return [$str . '_'];

    $here = substr($str, 0, 2);
    $next = solution(substr($str, 2));

    return (!$next) ? [$here]: array_merge([$here], $next);
}

class MyTestCases extends TestCase
{
    public function testBasicTest1() {
        $pairs = solution('cdabefg');
        $this->assertSame(is_array($pairs), true, 'solution did not return an array.');
        $this->assertSame(count($pairs), 4, 'solution did not return an array with enough pairs.');
        $this->assertSame($pairs[0], 'cd', 'solution did not return pairs with correct value.');
        $this->assertSame($pairs[3], 'g_', 'solution did not return pairs with correct value.');
    }
    public function testBasicTest2() {
        $pairs = solution('abcd');
        $this->assertSame(count($pairs), 2, 'solution did not return an array with enough pairs.');
        $this->assertSame($pairs[1], 'cd', 'solution did not return pairs with correct value.');
    }
}

$t = new MyTestCases();
$t->testBasicTest1();
$t->testBasicTest2();

/* Best:
    function solution($str) {
        if (mb_strlen($str) % 2 != 0) $str .= "_";
        return str_split($str, 2);
    }
*/
