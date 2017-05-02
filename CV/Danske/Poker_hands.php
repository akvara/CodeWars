<?php

include_once __DIR__.'/vendor/autoload.php';
use PHPUnit\Framework\TestCase;

$RANK = '23456789TJQKA';
$RANKED_FUNCTIONS = [
    'highest_value_card',
    'one_pair',
    'two_pairs',
    'three_of_a_kind',
    'straight',
    'pocker_flush',
    'full_house',
    'four_of_a_kind',
    'straight_flush',
    'royal_flush'
];

function compare_line($line): int {
    $hands = array_chunk(explode(' ', $line), 5);

    return compare_hands($hands[0], $hands[1]);
}

function compare_hands(array $hand1, array $hand2): int {
    return 0;
}

/* Compares values according to rank */
function by_rank($val1, $val2) {
    GLOBAL $RANK;

    return strpos($RANK, $val1) <=> strpos($RANK, $val2);
}

function cards_values(array $hand):array {
    return array_map(function ($el) {return strval($el[0]);}, $hand);
}

function cards_suits(array $hand):array {
    return array_map(function ($el) {return strval($el[1]);}, $hand);
}

/* Returns highest value of given cards */
function highest_value_card(array $hand): string {
    GLOBAL $RANK;

    $highest = $RANK[0];
    foreach ($hand as $card) {
        if (by_rank($card[0], $highest) === 1) $highest = $card[0];
    }

    return $highest;
}

/* Returns highest of pairs in hand or false */
function one_pair(array $hand) {
    $values = cards_values($hand);

    $dups = [];
    foreach(array_count_values($values) as $val => $c)
        if($c === 2) $dups[] = strval($val);

    if (count($dups) === 0) return false;

    usort($dups, "by_rank");

    return $dups[count($dups) - 1];
}

/* Returns two pairs in hand or null */
function two_pairs(array $hand) {
    $values = cards_values($hand);

    $dups = [];
    foreach(array_count_values($values) as $val => $c)
        if($c === 2) $dups[] = strval($val);

    if (count($dups) != 2) return false;

    usort($dups, "by_rank");

    return $dups;
}

/* Returns Three cards of the same value or null */
function three_of_a_kind(array $hand) {
    $values = cards_values($hand);

    $threes = false;
    foreach(array_count_values($values) as $val => $c)
        if($c === 3) $threes = strval($val);

    return $threes;
}

/* Returns cards of consecutive values or false */
function straight(array $hand) {
    GLOBAL $RANK;

    $values = cards_values($hand);

    usort($values, "by_rank");
    $row = implode($values);
    if (strpos($RANK, $row) === false) return false;

    return $row;
}

/* Returns suit if all cards of the same suit or false */
function pocker_flush(array $hand) {
    $suits = cards_suits($hand);

    $same = array_count_values($suits);

    if (count($same) > 1) return false;

    return current(array_keys($same));
}

/* Returns two pairs in hand or null */
function full_house(array $hand) {
    $suits = cards_values($hand);

    $same = array_count_values($suits);
    if (count($same) != 2) return false;

    return $same;
}


/* Returns four cards of the same value or null */
function four_of_a_kind(array $hand) {
    $values = cards_values($hand);

    $four = false;

    foreach(array_count_values($values) as $val => $c)
        if($c === 4) $four = strval($val);

    return $four;
}

/* Returns cards of consecutive values of the same suit or false */
function straight_flush(array $hand) {
    if (!pocker_flush($hand)) return false;

    return straight($hand);
}

/* Returns cards of consecutive values of the same suit or false */
function royal_flush(array $hand) {
    if (!pocker_flush($hand)) return false;

    return straight($hand) === 'TJQKA';
}

function poker_rank(array $hand) {
    global $RANKED_FUNCTIONS;
    $ranked_function_index = count($RANKED_FUNCTIONS) - 1;
    $func = $RANKED_FUNCTIONS[$ranked_function_index];

    while ($ranked_function_index > 0 && $func($hand) === false) {
        $ranked_function_index--;
        $func = $RANKED_FUNCTIONS[$ranked_function_index];
    }

    return $ranked_function_index;
}

/* Tests */
class PokerHandsTestCases extends TestCase
{
    public function testHelpers() {
        $this->assertSame(by_rank("T", "9"), 1, 'T should higher than 9.');
        $this->assertSame(by_rank("2", "3"), -1, '2 should be lower than 3.');
        $this->assertSame(highest_value_card(["2H", "2C", "2S", "2D", "4D"]), '4', 'High Card should be 4.');
        $this->assertSame(highest_value_card(["2H", "AC", "QS", "TS", "4D"]), 'A', 'High Card should be A.');
        $this->assertSame(one_pair(["AH", "AC", "3S", "3H", "4D"]), 'A', 'One pair should be A.');
        $this->assertSame(one_pair(["TH", "TC", "3S", "3H", "3D"]), 'T', 'One pair should be T.');
        $this->assertSame(two_pairs(["AH", "AC", "KS", "KH", "4D"]), ['K', 'A'], 'Pairs should be K and A.');
        $this->assertSame(three_of_a_kind(["AH", "AC", "KS", "KH", "KD"]), 'K', 'Three of a Kind should be K ');
        $this->assertSame(straight(["AH", "TC", "QS", "KH", "JD"]), 'TJQKA', 'Straight should be TJQKA.');
        $this->assertSame(straight(["3H", "6C", "2S", "5H", "4D"]), '23456', 'Straight should be 23456.');
        $this->assertSame(pocker_flush(["3H", "6H", "2H", "5H", "4H"]), 'H', 'Flush should be H.');
        $this->assertSame(full_house(["3S", "6H", "6D", "3H", "3D"]), ['3' => 3, '6' => 2], 'Full house wrong.');
        $this->assertSame(four_of_a_kind(["3S", "3H", "6D", "3C", "3D"]), '3', 'Four of a Kind should be 3.');
        $this->assertSame(straight_flush(["3H", "6H", "2H", "5H", "4H"]), '23456', 'Straight flush should be 23456.');
        $this->assertSame(royal_flush(["AH", "TH", "KH", "JH", "QH"]), true, 'Royal flush should be true.');
    }

    public function testRanking() {
        $this->assertSame(poker_rank(["2H", "7C", "QS", "TS", "4D"]), 0, 'High Card should have been');
        $this->assertSame(poker_rank(["TH", "QC", "3S", "3H", "4D"]), 1, 'One pair should have been.');
        $this->assertSame(poker_rank(["AH", "AC", "KS", "KH", "4D"]), 2, 'Two Pairs should have been.');
        $this->assertSame(poker_rank(["3H", "6C", "2S", "3H", "3D"]), 3, 'Three of a Kind should have been.');
        $this->assertSame(poker_rank(["3H", "6C", "2S", "5H", "4D"]), 4, 'Straight should have been.');
        $this->assertSame(poker_rank(["3H", "TH", "2H", "5H", "4H"]), 5, 'Flush should have been.');
        $this->assertSame(poker_rank(["3S", "6H", "6D", "3H", "3D"]), 6, 'Full house should have been.');
        $this->assertSame(poker_rank(["3S", "3H", "6D", "3C", "3D"]), 7, 'Four of a Kind should have been.');
        $this->assertSame(poker_rank(["3H", "6H", "2H", "5H", "4H"]), 8, 'Straight flush should have been.');
        $this->assertSame(poker_rank(["AH", "TH", "KH", "JH", "QH"]), 9, 'Royal flush should have been.');
    }

    public function testCases() {
        $this->assertSame(compare_line("2H 2C 2S 2S 3D 2C 2S 2S 2D 4D"), -1, 'High Card should win.');
        $this->assertSame(compare_line("5H 5C 6S 7S KD 2C 3S 8S 8D TD"), -1, 'Pair of Fives < Pair of Eights.');
        $this->assertSame(compare_line("5D 8C 9S JS AC 2C 5C 7D 8S QH"), 1, 'A > Q.');
        $this->assertSame(compare_line("2D 9C AS AH AC 3D 6D 7D TD QD"), -1, 'Three Aces < Flush with Diamonds.');
        $this->assertSame(compare_line("4D 6S 9H QH QC 3D 6D 7H QD QS"), 1, 'Pair of Queens; 9 > 7.');
        $this->assertSame(compare_line("2H 2D 4C 4D 4S 3C 3D 3S 9S 9D"), -1, 'Full House; 4 > 3.');
    }
}

$t = new PokerHandsTestCases();
$t->testHelpers();
$t->testRanking();

