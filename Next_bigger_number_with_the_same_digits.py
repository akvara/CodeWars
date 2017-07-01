from itertools import permutations
def next_bigger(n):
    perm = sorted(int((''.join(s))) for s in set(permutations(str(n), len(str(n)))))
    i = perm.index(n)
    if i < len(perm):
        return perm[i +1 ]
    return -1


from KataTestSuite import Test
Test = Test()


Test.assert_equals(next_bigger(12),21)
Test.assert_equals(next_bigger(513),531)
Test.assert_equals(next_bigger(2017),2071)
Test.assert_equals(next_bigger(414),441)
Test.assert_equals(next_bigger(144),414)