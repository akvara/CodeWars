def xo(s):
    return len([c  for c in list(s) if c.lower() == 'o']) == len([c  for c in list(s) if c.lower() == 'x'])

from KataTestSuite import Test
Test = Test()


Test.expect(xo('xo'))
Test.expect(xo('xo0'))
Test.expect(not xo('xxxoo'))
