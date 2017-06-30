
def opposite(couple):
    couple.sort()
    return couple in (['EAST', 'WEST'], ['NORTH', 'SOUTH'])

def dirReduc(arr):
    changes = True
    while changes:
        changes = False
        i = 1
        while i < len(arr):
            if opposite([arr[i], arr[i - 1]]):
                del arr[i]
                del arr[i - 1]
                changes = True
            i += 1
    return arr


from KataTestSuite import Test
test = Test()


a = ["NORTH", "SOUTH", "SOUTH", "EAST", "WEST", "NORTH", "WEST"]
test.assert_equals(dirReduc(a), ['WEST'])
u=["NORTH", "WEST", "SOUTH", "EAST"]
test.assert_equals(dirReduc(u), ["NORTH", "WEST", "SOUTH", "EAST"])