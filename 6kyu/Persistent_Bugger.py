def persistence(n):
    s = str(n)
    num = 0
    while len(s) > 1:
        s = str(reduce(lambda x, y: x * y, [int( i) for i in list(s)]))
        num += 1
    return num


from KataTestSuite import Test
Test = Test()


Test.it("Basic tests")
Test.assert_equals(persistence(39), 3)
Test.assert_equals(persistence(4), 0)
Test.assert_equals(persistence(25), 2)
Test.assert_equals(persistence(999), 4)
