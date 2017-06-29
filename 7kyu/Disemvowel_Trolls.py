def disemvowel(string):
    return ''.join(c for c in list(string) if c.lower() not in ('a', 'e', 'i', 'o', 'u'))


from KataTestSuite import Test
test = Test()

test.assert_equals(disemvowel("This website is for losers LOL!"),
                   "Ths wbst s fr lsrs LL!")