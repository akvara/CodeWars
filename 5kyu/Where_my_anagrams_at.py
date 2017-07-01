def anagrams(word, words):
    srt = sorted(word)
    return [w for w in words if sorted(w) == srt]

from KataTestSuite import Test
test = Test()

test.assert_equals(anagrams('abba', ['aabb', 'abcd', 'bbaa', 'dada']), ['aabb', 'bbaa'])
test.assert_equals(anagrams('racer', ['crazer', 'carer', 'racar', 'caers', 'racer']), ['carer', 'racer'])