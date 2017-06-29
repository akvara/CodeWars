def high_and_low(numbers):
    nn = [int(x) for x in numbers.split(" ")]
    return "%i %i" % (max(nn), min(nn))


import unittest


