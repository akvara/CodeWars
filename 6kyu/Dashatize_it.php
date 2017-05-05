<?php

include_once __DIR__.'/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;


function dashatize(int $num): string {
    $res = '';
    for ($i = 0; $i < strlen(strval($num)); $i++) {
        $c = strval($num)[$i];
        if (intval($c) % 2 === 0)
            $res .= $c;
        else
            $res .= '-' . $c. '-';
    }
    $res = str_replace('--', '-', $res);
    if ($res[0] === '-') $res = substr($res, 1);
    if ($res[strlen($res) - 1] === '-') $res = substr($res, 0, strlen($res) - 1);

    return $res;
}

class MyTestCases extends TestCase
{
    public function testBasic() {
        $this->assertEquals('2-7-4', dashatize(274));
        $this->assertEquals('5-3-1-1', dashatize(5311));
        $this->assertEquals('86-3-20', dashatize(86320));
        $this->assertEquals('9-7-4-3-02', dashatize(974302));
    }

    public function testWeird() {
        $this->assertEquals('0', dashatize(0));
        $this->assertEquals('1', dashatize(-1));
        $this->assertEquals('28-3-6-9', dashatize(-28369));
    }
}

$t = new MyTestCases();
$t->testBasic();

/*
 *     return trim(str_replace('--', '-', preg_replace('/([13579])/','-$1-', $num)), '-');
 */