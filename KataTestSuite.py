class Test:
    def assert_equals(self, tobe, isit):
        if tobe == isit:
            print('\x1b[6;30;42m' + 'Ok' + '\x1b[0m')
            return
        print('\x1b[1;37;41m' + 'No,' + '\x1b[0m' +  str(tobe) + '\x1b[1;37;41m' + " != " + '\x1b[0m'+ str(isit))