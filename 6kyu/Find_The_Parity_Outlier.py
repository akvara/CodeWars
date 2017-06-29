def find_outlier(integers):
    odd = [i for i in integers if i % 2 == 0]
    even = [i for i in integers if i % 2 != 0]
    if len(odd) == 1:
        return odd[0]
    return even [0]


from KataTestSuite import Test
test = Test()


test.assert_equals(find_outlier([2,6,8,10,3]), 3)
