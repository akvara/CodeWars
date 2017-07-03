import re
def increment_string(strng):
    strPart = ''
    numPart = '0'
    matchObj = re.match(r'([0-9]*)(.*)', strng[::-1])
    if matchObj:
        if matchObj.group(1):
            numPart = matchObj.group(1)[::-1]
        if matchObj.group(2):
            strPart = matchObj.group(2)[::-1]

    return strPart + str(int(numPart) + 1).zfill(len(numPart))



from KataTestSuite import Test
Test = Test()


Test.assert_equals(increment_string("foo"), "foo1")
Test.assert_equals(increment_string("foobar001"), "foobar002")
Test.assert_equals(increment_string("foobar1"), "foobar2")
Test.assert_equals(increment_string("foobar00"), "foobar01")
Test.assert_equals(increment_string("foobar99"), "foobar100")
Test.assert_equals(increment_string("foobar099"), "foobar100")
Test.assert_equals(increment_string(""), "1")
Test.assert_equals(increment_string("1"), "2")
# Test.assert_equals(increment_string('.j8)7GV9w,rPu{e3586009]#S -D;Y32607vsJ"%871557!Qhyea506.Zc>$505(GzjJ?6706500665249'), "10")