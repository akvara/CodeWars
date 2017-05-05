<?php

include_once __DIR__.'/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;

function isValidIP(string $str): bool
{
    $octets = explode(".", $str);
    if (count($octets) !== 4) return false;
    foreach ($octets as $oct) if (!isValidOctet($oct)) return false;
    return true;
}

function isValidOctet($oct) {
    return
        strval(intval($oct)) === $oct &&
            $oct >= 0 &&
            $oct <= 255;
}

class ValidIpTest extends TestCase
{
    public function testValid()
    {
        $valid = [
            '0.0.0.0',
            '255.255.255.255',
            '238.46.26.43',
            '0.34.82.53',
        ];

        foreach ($valid as $input) {
            $this->assertTrue(isValidIP($input), "Failed asserting that '$input' is a valid IP4 address.");
        }
    }

    public function testInvalid()
    {
        $invalid = [
            '',
            'abc.def.ghi.jkl',
            '123.456.789.0',
            ' 1.2.3.4',
        ];

        foreach($invalid as $input) {
            $this->assertFalse(isValidIP($input), "Failed asserting that '$input' is an invalid IP4 address.");
        }
    }
}


$t = new ValidIpTest();
$t->testValid();
$t->testInvalid();


//var_dump(isValidOctet('012'));
