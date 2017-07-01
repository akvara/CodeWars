def solution(args):
    res = []
    begin = None
    for i in range(1, len(args)):
        if args[i] - args[i - 1] == 1:
            if not begin:
                begin = args[i - 1]
        else:
            if begin:
                range_or_two_separate(begin, args[i - 1], res)
                begin = None
            else:
                res.append(str(args[i - 1]))

    if begin:
        range_or_two_separate(begin, args[i], res)
    else:
        res.append(str(args[i]))

    return (",").join(res)

def range_or_two_separate(first, second, res):
    if second - first == 1:
        res.append(str(first))
        res.append(str(second))
    else:
        res.append(str(first) + "-" + str(second))

from KataTestSuite import Test
Test = Test()


Test.describe("Sample Test Cases")

Test.it("Simple Tests")
Test.assert_equals(solution([-6,-3,-2,-1,0,1,3,4,5,7,8,9,10,11,14,15,17,18,19,20]), '-6,-3-1,3-5,7-11,14,15,17-20')
Test.assert_equals(solution([-3,-2,-1,2,10,15,16,18,19,20]), '-3--1,2,10,15,16,18-20')