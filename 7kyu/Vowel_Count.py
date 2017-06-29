def getCount(inputStr):
    return len([c  for c in list(inputStr) if c.lower() in ('a', 'e', 'i', 'o', 'u')])


from KataTestSuite import Test
test = Test()


test.assert_equals(getCount("abracadabra"), 5)