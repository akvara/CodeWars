<?php

include_once __DIR__.'/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;

$NATO = [
    'A' => 'Alfa',
    'B' => 'Bravo',
    'C' => 'Charlie',
    'D' => 'Delta',
    'E' => 'Echo',
    'F' => 'Foxtrot',
    'G' => 'Golf',
    'H' => 'Hotel',
    'I' => 'India',
    'J' => 'Juliet',
    'K' => 'Kilo',
    'L' => 'Lima',
    'M' => 'Mike',
    'N' => 'November',
    'O' => 'Oscar',
    'P' => 'Papa',
    'Q' => 'Quebec',
    'R' => 'Romeo',
    'S' => 'Sierra',
    'T' => 'Tango',
    'U' => 'Uniform',
    'V' => 'Victor',
    'W' => 'Whiskey',
    'X' => 'Xray',
    'Y' => 'Yankee',
    'Z' => 'Zulu',
    '-' => 'Dash'
];

function to_nato($words){
    GLOBAL $NATO;
    $res = '';
    for ($i = 0; $i < strlen($words); $i++) {
            $c = strtoupper($words[$i]);
            $res .= (isset($NATO[$c]) ? $NATO[$c] : $c) . ' ';
    }
    $count = 1;
    while ($count) $res = str_replace('  ', ' ', $res, $count);
    return trim($res);
}

class MyTestCases extends TestCase
{
    public function testShouldReturnTranslatedString() {
        $this->assertEquals(to_nato('IFYOUCANREAD'), "India Foxtrot Yankee Oscar Uniform Charlie Alfa November Romeo Echo Alfa Delta");
        $this->assertEquals(to_nato('If you can read'), "India Foxtrot Yankee Oscar Uniform Charlie Alfa November Romeo Echo Alfa Delta");
        $this->assertEquals(to_nato('Did not see that coming'), "Delta India Delta November Oscar Tango Sierra Echo Echo Tango Hotel Alfa Tango Charlie Oscar Mike India November Golf");
    }
}

$t = new MyTestCases();
$t->testShouldReturnTranslatedString();
