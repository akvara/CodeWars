<?php

include_once __DIR__.'/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;

/**
 * Class VigenèreCipher
 */
class VigenèreCipher {
    /** @var string */
    private $key;

    /** @var string */
    private $alphabet;

    /** @var int */
    private $ordA;

    /** @var int */
    private $ordZ;

    /**
     * VigenèreCipher constructor.
     * @param string $key
     * @param string $alphabet
     */
    public function __construct($key, $alphabet)
    {
        $this->key = $key;
        $this->alphabet = $alphabet;
        $this->ordA = ord($this->alphabet[0]);
        $this->ordZ = ord($this->alphabet[strlen($this->alphabet) - 1]);
    }

    public function encode(string $s):string {
        $keyPad = str_pad('', strlen($s), $this->key, STR_PAD_RIGHT);
        $out = '';

        for ($i = 0; $i < strlen ($s); $i++) {
            $out .= $this->shift($s[$i], ord($keyPad[$i]) - $this->ordA);
        }

        return $out;
    }

    public function decode(string $s):string {
        $keyPad = str_pad('', strlen($s), $this->key, STR_PAD_RIGHT);
        $out = '';

        for ($i = 0; $i < strlen($s); $i++) {
            $out .= $this->shift($s[$i],  $this->ordZ - ord($keyPad[$i]) + 1);
        }

        return $out;
    }

    private function shift($char, $shift)
    {
        $ord = ord($char);

        if ($ord > $this->ordZ || $ord < $this->ordA) return $char;

        $ord = ord($char) + $shift;
        if ($ord > $this->ordZ) $ord = $ord - $this->ordZ + $this->ordA - 1;
        if ($ord < $this->ordA) $ord = $ord + $this->ordZ - $this->ordA + 1;

        return chr($ord);
    }
}


class MyTestCases extends TestCase
{
    public function testEncode() {

        $alphabet = 'abcdefghijklmnopqrstuvwxyz';
        $key = 'password';
        $c = new VigenèreCipher($key, $alphabet);

        $this->assertEquals('rovwsoiv', $c->encode('codewars'));
    }
    public function testDecode() {

        $alphabet = 'abcdefghijklmnopqrstuvwxyz';
        $key = 'password';
        $c = new VigenèreCipher($key, $alphabet);

        $this->assertEquals('waffles', $c->decode('laxxhsj'));
    }
}

$t = new MyTestCases();
$t->testEncode();
$t->testDecode();

