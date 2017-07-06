class VigenereAutokeyCipher:
    def __init__(self, key, abc):
        self.key = key
        self.abc = abc

    def encode(self, text):
        pass

    def decode(self, text):
        pass


from KataTestSuite import Test
test = Test()


key = 'PASSWORD';
abc = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

c = VigenereAutokeyCipher(key, abc);
Test.assert_equals(c.encode('AAAAAAAAPASSWORDAAAAAAAA'), 'PASSWORDPASSWORDPASSWORD')
Test.assert_equals(c.decode('PASSWORDPASSWORDPASSWORD'), 'AAAAAAAAPASSWORDAAAAAAAA')