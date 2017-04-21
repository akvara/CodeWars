<?php

include_once __DIR__.'/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;

function camel_case(string $s): string {
    return implode(array_map(function(string $s) {return ucfirst($s);}, array_filter(explode(' ', $s))));
}


class CamelCaseTest extends TestCase {
    public function testFixed() {
        $this->assertEquals("TestCase", camel_case("test case"));
        $this->assertEquals("CamelCaseMethod", camel_case("camel case method"));
        $this->assertEquals("SayHello", camel_case("say hello "));
        $this->assertEquals("CamelCaseWord", camel_case(" camel case word"));
        $this->assertEquals("", camel_case(""));
    }
}

$t = new CamelCaseTest();
$t->testFixed();
