def to_weird_case(string):
    l = [c for c in list(string)]
    i = 0
    res = []
    for c in l:
        res.append(c.upper() if i%2 == 0 else c.lower())
        if (c.isalpha()):
            i += 1
        else:
            i = 0
    return ('').join(res)


from KataTestSuite import Test
test = Test()


test.describe('to_weird_case')

test.it('should return the correct value for a single word')
test.assert_equals(to_weird_case('This'), 'ThIs')
test.assert_equals(to_weird_case('is'), 'Is')

test.it('should return the correct value for multiple words')
test.assert_equals(to_weird_case('This is a test'), 'ThIs Is A TeSt')
