<?php

function validBraces($braces){
    $count = 1;
    while ($count) $braces = str_replace(['()', '[]', '{}'], '', $braces, $count);

    return $braces === '';
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
assertEquals(false, validBraces(")()("));

echo PHP_EOL;
