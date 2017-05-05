<?php

include_once __DIR__.'/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;


function ipv4_address($address){
    preg_match('/^(\d+)\.(\d+).(\d+).(\d+)\z/', $address, $matches);
    if (!$matches) return false;
    for ($i = 1; $i <= 4; $i++) {
        if (strval(intval($matches[$i])) !== $matches[$i]) return false;
        if (intval($matches[$i]) > 255) return false;
    }
    return true;
}


class MyTestCases extends TestCase
{
    public function testBasics() {
        $this->assertEquals( False,ipv4_address(""));
        $this->assertEquals( True,ipv4_address("127.0.0.1"));
        $this->assertEquals( True,ipv4_address("0.0.0.0"));
        $this->assertEquals( True,ipv4_address("255.255.255.255"));
        $this->assertEquals( True,ipv4_address("10.20.30.40"));
        $this->assertEquals( False,ipv4_address("10.256.30.40"));
        $this->assertEquals( False,ipv4_address("10.20.030.40"));
        $this->assertEquals( False,ipv4_address("127.0.1"));
        $this->assertEquals( False,ipv4_address("127.0.0.0.1"));
        $this->assertEquals( False,ipv4_address("..255.255"));
        $this->assertEquals( False,ipv4_address("127.0.0.1\n"));
        $this->assertEquals( False,ipv4_address("\n127.0.0.1"));
        $this->assertEquals( False,ipv4_address(" 127.0.0.1"));
        $this->assertEquals( False,ipv4_address("127.0.0.1 "));
        $this->assertEquals( False,ipv4_address(" 127.0.0.1 "));
    }
}

$t = new MyTestCases();
$t->testBasics();
