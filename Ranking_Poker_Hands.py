from collections import Counter
import functools
class PokerHand(object):

    RANK = '23456789TJQKA'
    RANKED_FUNCTIONS = [
        'highest_value_card',
        'one_pair',
        'two_pairs',
        'three_of_a_kind',
        'straight',
        'poker_flush',
        'full_house',
        'four_of_a_kind',
        'straight_flush',
        'royal_flush'
    ]
    RESULT = ["Loss", "Tie", "Win"]

    def __init__(self, hand):
        self.hand = hand

    def compare_with(self, other):
        hand1rank = self.poker_rank(self.hand.split(" "))
        hand2rank = self.poker_rank(other.hand.split(" "))

        if hand1rank['rank'] > hand2rank['rank']:
            return self.str_result(1)
        if hand1rank['rank'] < hand2rank['rank']:
            return self.str_result(-1)

        # if ranking is the same, compare ranking value
        by_value = self.by_values(hand1rank['result']['value'], hand2rank['result']['value'])
        if by_value != 0:
            return self.str_result(by_value)

        # compare remaining cards
        remaining1 = hand1rank['result']['remaining']
        remaining2 = hand2rank['result']['remaining']
        while len(remaining1) > 0:
            rem1 = self.highest_value_card(remaining1)
            rem2 = self.highest_value_card(remaining2)
            by_value = self.by_values(rem1['value'], rem2['value'])
            if by_value != 0:
                return self.str_result(by_value)
            remaining1 = rem1['remaining']
            remaining2 = rem2['remaining']

        # tie
        return self.str_result(0)

    def poker_rank(self, hand):
        ranked_function_index = len(self.RANKED_FUNCTIONS) - 1
        func =  getattr(self, self.RANKED_FUNCTIONS[ranked_function_index])
        value = func(hand)
        while ranked_function_index > 0 and not value:
            ranked_function_index -= 1
            func =  getattr(self, self.RANKED_FUNCTIONS[ranked_function_index])
            value = func(hand)

        return {'rank':ranked_function_index, 'result': value}

    def royal_flush(self, hand):
        # Returns cards are of consecutive values of the same suit or false
        if not self.poker_flush(hand):
            return False
        straight = self.straight(hand)
        if not straight:
            return False
        if not straight['value']== 'T':
            return False

        return {'value': True, 'remaining': []}

    def straight_flush(self, hand):
        # Returns cards are of consecutive values of the same suit or False
        if not self.poker_flush(hand):
            return False
        return self.straight(hand)

    def four_of_a_kind(self, hand):
        # Returns four cards are of the same value or null
        return self.n_of_a_kind(hand, 4)

    def full_house(self, hand):
        # Returns two pairs in hand or null
        suits = self.cards_values(hand)
        same = Counter(suits)
        if len(same) != 2:
            return False
        two_three = dict((v,k) for k,v in same.items())
        return {'value': two_three[3] + two_three[2], 'remaining': []}

    def poker_flush(self, hand):
        # Returns suit if all cards of the same suit or False
        suits = self.cards_suits(hand)
        same = Counter(suits)
        if len(same) > 1:
            return False
        values = self.cards_values(hand)
        values.sort(key = functools.cmp_to_key(self.by_value))
        return {'value': values[::-1], 'remaining': []}

    def straight(self, hand):
        # Returns cards of consecutive values or False
        values = self.cards_values(hand)
        values.sort(key = functools.cmp_to_key(self.by_value))

        row = ''.join(values)
        pos = self.RANK.find(row)
        if pos < 0:
            return False
        return {'value': self.RANK[pos], 'remaining': []}

    def three_of_a_kind(self, hand):
        # Returns Three cards of the same value or null
        return self.n_of_a_kind(hand, 3)

    def two_pairs(self, hand):
        # Returns two pairs in hand or null
        counter = Counter(self.cards_values(hand))
        dups = [str(d) for d in counter if counter[d] == 2]

        if len(dups) != 2:
            return False
        dups.sort(key = functools.cmp_to_key(self.by_value))
        val = ''.join(dups)[::-1]
        return {'value': val, 'remaining': self.remove_values(self.remove_values(hand, val[0]), val[1])}

    def one_pair(self, hand):
        # Returns highest of pairs in hand or False
        return self.n_of_a_kind(hand, 2)

    def highest_value_card(self, hand):
        # Returns highest value of given cards
        values = self.cards_values(hand)
        values.sort(key = functools.cmp_to_key(self.by_value))
        reversed = ''.join(values[::-1])
        return {'value': reversed[0], 'remaining': self.remove_values(hand, reversed[0])}

    ### Helpers

    def cards_suits(self, hand):
        # Returns hand card values
        return [el[1] for el in hand]

    def cards_values(self, hand):
        # Returns hand card values
        return [el[0] for el in hand]

    def by_value(self, val1, val2):
        # Compares values according to value rank
        return self.cmp(self.RANK.index(val1), self.RANK.index(val2))

    def by_values(self, str1, str2):
        # Compares values according to value rank
        for i in range(len(str1)):
            vs = self.cmp(self.RANK.index(str1[i]), self.RANK.index(str2[i]))
            if vs != 0:
                return vs
        return 0

    def remove_values(self, hand, val):
        # Returns array without given values
        return [el for el in hand if el[0] != val]

    def n_of_a_kind(self, hand, n):
        # Returns n cards of the same value or null
        counter = Counter(self.cards_values(hand))
        of_a = [str(d) for d in counter if counter[d] == n]

        if not of_a:
            return False
        return {'value': of_a[0], 'remaining': self.remove_values(hand, of_a[0])}

    def str_result(self, idx):
        return self.RESULT[idx + 1]

    def cmp(self, a, b):
        return (a > b) - (a < b)


from KataTestSuite import Test
test = Test()

def test_helpers():
    ph = PokerHand('AA')
    test.assert_equals(ph.by_value("T", "9"), 1, 'T should higher than 9.')
    test.assert_equals(ph.by_value("2", "3"), -1, '2 should be lower than 3.')
    test.assert_equals(
        ph.highest_value_card(["2H", "2C", "2S", "2D", "4D"]),
        {'value':'4', 'remaining': ["2H", "2C", "2S", "2D"]},
        'High Card should be 4.')
    test.assert_equals(
        ph.one_pair(["AH", "AC", "3S", "3H", "4D"]),
        {'value': 'A', 'remaining': ["3S", "3H", "4D"]},
        'One pair should be A.')
    test.assert_equals(
        ph.one_pair(["TH", "TC", "3S", "3H", "3D"]),
        {'value': 'T', 'remaining': ["3S", "3H", "3D"]},
        'One pair should be T.')
    test.assert_equals(
        ph.two_pairs(["AH", "AC", "KS", "KH", "4D"]),
        {'value': 'AK', 'remaining': ["4D"]},
        'Pairs should be K and A.')
    test.assert_equals(
        ph.three_of_a_kind(["AH", "AC", "KS", "KH", "KD"]),
        {'value': 'K', 'remaining': ["AH", "AC"]},
        'Three of a Kind should be K ')
    test.assert_equals(
        ph.straight(["AH", "TC", "QS", "KH", "JD"]),
        {'value': 'T', 'remaining': []},
        'Straight should be TJQKA.')
    test.assert_equals(
        ph.straight(["3H", "6C", "2S", "5H", "4D"]),
        {'value': '2', 'remaining': []},
        'Straight should be 23456.')
    test.assert_equals(
        ph.poker_flush(["3H", "6H", "2H", "5H", "4H"]),
        {'value': ['6', '5', '4', '3', '2'], 'remaining': []},
        'Flush should be range 6...2')
    test.assert_equals(
        ph.full_house(["3S", "6H", "6D", "3H", "3D"]),
        {'value': '36', 'remaining': []},
        'Full house wrong.')
    test.assert_equals(
        ph.four_of_a_kind(["3S", "3H", "6D", "3C", "3D"]),
        {'value': '3', 'remaining': ["6D"]},
        'Four of a Kind should be 3.')
    test.assert_equals(
        ph.straight_flush(["3H", "6H", "2H", "5H", "4H"]),
        {'value': '2', 'remaining': []},
        'Straight flush should be 2.')
    test.assert_equals(
        ph.royal_flush(["AH", "TH", "KH", "JH", "QH"]),
        {'value': True, 'remaining': []},
        'Royal flush should be true.')
    test.assert_equals(
        ph.highest_value_card(["2H", "AC", "QS", "TS", "4D"]),
        {'value': 'A', 'remaining': ["2H", "QS", "TS", "4D"]},
        'High Card should be A.')

def runTest(msg, expected, hand, other):
    player, opponent = PokerHand(hand), PokerHand(other)
    test.assert_equals(player.compare_with(opponent), expected, "{}: '{}' against '{}'".format(msg, hand, other))


test_helpers()

runTest("Wtf",                                "Loss", '3S 8S 9S 5S KS', '4C 5C 9C 8C KC')
runTest("Highest straight flush wins",        "Loss", "2H 3H 4H 5H 6H", "KS AS TS QS JS")
runTest("Straight flush wins of 4 of a kind", "Win",  "2H 3H 4H 5H 6H", "AS AD AC AH JD")
runTest("Highest 4 of a kind wins",           "Win",  "AS AH 2H AD AC", "JS JD JC JH 3D")
runTest("4 Of a kind wins of full house",     "Loss", "2S AH 2H AS AC", "JS JD JC JH AD")
runTest("Full house wins of flush",           "Win",  "2S AH 2H AS AC", "2H 3H 5H 6H 7H")
runTest("Highest flush wins",                 "Win",  "AS 3S 4S 8S 2S", "2H 3H 5H 6H 7H")
runTest("Flush wins of straight",             "Win",  "2H 3H 5H 6H 7H", "2S 3H 4H 5S 6C")
runTest("Equal straight is tie", 	  	      "Tie",  "2S 3H 4H 5S 6C", "3D 4C 5H 6H 2S")
runTest("Straight wins of three of a kind",   "Win",  "2S 3H 4H 5S 6C", "AH AC 5H 6H AS")
runTest("3 Of a kind wins of two pair",       "Loss", "2S 2H 4H 5S 4C", "AH AC 5H 6H AS")
runTest("2 Pair wins of pair",                "Win",  "2S 2H 4H 5S 4C", "AH AC 5H 6H 7S")
runTest("Highest pair wins",                  "Loss", "6S AD 7H 4S AS", "AH AC 5H 6H 7S")
runTest("Pair wins of nothing",               "Loss", "2S AH 4H 5S KC", "AH AC 5H 6H 7S")
runTest("Highest card loses",                 "Loss", "2S 3H 6H 7S 9C", "7H 3C TH 6H 9S")
runTest("Highest card wins",                  "Win",  "4S 5H 6H TS AC", "3S 5H 6H TS AC")
runTest("Equal cards is tie",		          "Tie",  "2S AH 4H 5S 6C", "AD 4C 5H 6H 2C")
