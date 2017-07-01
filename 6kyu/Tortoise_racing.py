def race(v1, v2, g):
    seconds = g * 3600 / (v2 - v1)
    return None if seconds < 0 else seconds_to_time(seconds)

def seconds_to_time(seconds):
    m, s = divmod(seconds, 60)
    h, m = divmod(m, 60)
    return [int(h), int(m), int(s)]

from KataTestSuite import Test
Test = Test()


Test.it("Basic Tests")
Test.assert_equals(race(720, 850, 70), [0, 32, 18])
Test.assert_equals(race(80, 91, 37), [3, 21, 49])
Test.assert_equals(race(80, 100, 40), [2, 0, 0])