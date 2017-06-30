def gap(g, m, n):
    print m
    prime1 = None
    while m <= n:
        if prime(m):
            if prime1 and  m - prime1 == g:
                return [prime1, m]
            prime1 = m
        m += 1


def prime(p):
    if p % 2 == 0:
        return False
    for d in range(3, int(p ** 0.5 + 1), 2):
        if p % d == 0:
            return False
    return True

from KataTestSuite import Test
Test = Test()


Test.describe("Gap")
Test.it("Basic tests")
Test.assert_equals(gap(2,100,110), [101, 103])
Test.assert_equals(gap(4,100,110), [103, 107])
Test.assert_equals(gap(6,100,110), None)
Test.assert_equals(gap(8,300,400), [359, 367])
Test.assert_equals(gap(10,300,400), [337, 347])

