import unittest


def high_and_low(numbers):
    nn = [int(x) for x in numbers.split(" ")]
    return "%i %i" % (max(nn), min(nn))

print high_and_low("1 -1")

#
#
# Test = unittest.TestCase()
#
# Test.assert_equals(high_and_low("1 -1"), "1 -1")


class TestBasic(unittest.TestCase):
    def testBasic(self):
        self.assertEqual("2 1", high_and_low("1 2"))


if __name__ == "__main__":
    unittest.main()