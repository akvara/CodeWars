def iq_test(numbers):
    oddness = [int(i) % 2 for i in numbers.split(" ")]
    return oddness.index(1)+1 if sum(oddness) == 1 else oddness.index(0)+1


from KataTestSuite import Test
test = Test()


test.assert_equals(iq_test("2 4 7 8 10"),3)
test.assert_equals(iq_test("1 2 2"), 1)
test.assert_equals(iq_test("1 1 2"), 3)