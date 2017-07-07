class RomanNumerals:

    @staticmethod
    def to_roman(number):
        ROMAN = (
            ('M', 1000),
            ('CM', 900),
            ('D', 500),
            ('CD', 400),
            ('C', 100),
            ('XC', 90),
            ('L', 50),
            ('XL', 40),
            ('X', 10),
            ('IX', 9),
            ('V', 5),
            ('IV', 4),
            ('I', 1)
        )
        res = ''
        idx = 0
        arabian = ROMAN[idx][1]

        while number > 0:
            if number >= arabian:
                number -= arabian
                res += ROMAN[idx][0]
            else:
                idx += 1
                arabian = ROMAN[idx][1]

        return res

    @staticmethod
    def from_roman(roman):
        ROMAN = (
            ('CM', 900),
            ('CD', 400),
            ('XC', 90),
            ('XL', 40),
            ('IX', 9),
            ('IV', 4),
            ('M', 1000),
            ('D', 500),
            ('C', 100),
            ('L', 50),
            ('X', 10),
            ('V', 5),
            ('I', 1)
        )
        number = 0
        for (r, a) in ROMAN:
            number += roman.count(r) * a
            roman = roman.replace(r, '')
        return number

from KataTestSuite import Test
test = Test()


test.assert_equals("M", RomanNumerals.to_roman(1000))
test.assert_equals("IV", RomanNumerals.to_roman(4))
test.assert_equals("I", RomanNumerals.to_roman(1))
test.assert_equals("MCMXC", RomanNumerals.to_roman(1990))
test.assert_equals("MMVIII", RomanNumerals.to_roman(2008))

test.assert_equals(1000, RomanNumerals.from_roman("M"))
test.assert_equals(4, RomanNumerals.from_roman("IV"))
test.assert_equals(1, RomanNumerals.from_roman("I"))
test.assert_equals(1990, RomanNumerals.from_roman("MCMXC"))
test.assert_equals(2008, RomanNumerals.from_roman("MMVIII"))