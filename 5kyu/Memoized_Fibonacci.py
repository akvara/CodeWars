def fibonacci(n):
    if n in [0, 1]:
        return n
    mem_2 = 0
    mem_1 = 1

    for x in range(2, n + 1):
        new = mem_1 + mem_2
        mem_2 = mem_1
        mem_1 = new
    return new


from KataTestSuite import Test
test = Test()


test.describe('Kata Test Suite')
test.it('should calculate large Fibonacci numbers')
test.assert_equals(fibonacci(70), 190392490709135)
test.assert_equals(fibonacci(60), 1548008755920)
test.assert_equals(fibonacci(50), 12586269025)