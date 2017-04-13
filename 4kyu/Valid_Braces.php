<?php

$BRACES = [
    '(' => ')',
    '[' => ']',
    '{' => '}'
];

function validBraces($braces){
    global $BRACES;
    if (strlen($braces) === 0) return true;

    if (array_key_exists($braces[0], $BRACES)) {
        $end = findClosingBrace(substr($braces, 1), $braces[0], $BRACES[$braces[0]]);
        if ($end === false) return false;
        $inside = validBraces(substr($braces, 1, $end ));

        return $inside && validBraces(substr($braces, $end + 2));
    }

    return false;
}

function findClosingBrace($input, $openingBrace, $closingBrace) {
    $open = 1;
    $i = 0;
    while ($i < strlen($input)) {
        if ($input[$i] === $openingBrace) {
            $open++;
        }
        if ($input[$i] === $closingBrace) {
            $open--;
            if ($open === 0) return $i;
        }
        $i++;
    }
    return false;
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

assertEquals(true, validBraces( "(){}[]" ));
assertEquals(false, validBraces( "(}" ));
assertEquals(false, validBraces( "[(])" ));
assertEquals(true, validBraces( "([{}])" ));

echo PHP_EOL;
