<?php

class CaesarCipher
{
    /** @var  int */
    private $shift;

    /**
     * CaesarCipher constructor.
     * @param int $shift
     */
    public function __construct($shift)
    {
        $this->shift = $shift;
    }

    public function encode(string $input): string {
        $out = '';

        for ($i=0; $i<strlen($input); $i++) {
            $out .= $this->shift($input[$i], $this->shift);
        }

        return $out;
    }

    public function decode(string $input): string {
        $out = '';

        for ($i=0; $i<strlen($input); $i++) {
            $out .= $this->shift($input[$i], -$this->shift);
        }

        return $out;
    }

    private function shift($char, $shift)
    {
        $ord = ord(strtoupper($char));

        if ($ord > ord('Z') || $ord < ord('A')) return $char;

        $ord = ord(strtoupper($char)) + $shift;
        if ($ord > ord('Z')) $ord = $ord - ord('Z') + ord('A') - 1;
        if ($ord < ord('A')) $ord = $ord + ord('Z') - ord('A') + 1;

        return chr($ord);
    }
}

// ***** Tests *****

function assertEquals($expect, $var) {
    if ($var === $expect) {
        echo ".";

        return true;
    }
    echo "\033[01;31m!\033[0m" . PHP_EOL;
    echo "---Expected---" . PHP_EOL;
    echo $expect . PHP_EOL;
    echo "-----Got------" . PHP_EOL;
    echo $var . PHP_EOL;

    return false;
}

// ***** Functional *****
$c = new CaesarCipher(5);

assertEquals('HTIJBFWX', $c->encode('Codewars'));
assertEquals('WAFFLES', $c->decode('BFKKQJX'));

echo PHP_EOL;
