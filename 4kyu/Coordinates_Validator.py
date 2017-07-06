def is_valid_coordinates(coordinates):
    crd = coordinates.split(", ")
    if len(crd) != 2:
        return False
    if not (is_number_in_range(crd[0], 90) and is_number_in_range(crd[1], 180)):
        return False
    return True


def is_number_in_range(s, max):
    if  ''.join(filter(lambda x: x not in '.-0123456789', s)):
        return False
    try:
        f = float(s)
        return abs(f) <= max
    except ValueError:
        return False

# Clever:
# return bool(re.match("-?(\d|[1-8]\d|90)\.?\d*, -?(\d|[1-9]\d|1[0-7]\d|180)\.?\d*$", coordinates))

from KataTestSuite import Test
test = Test()


test.describe("Example Test Cases")

test.it("should return true for valid coordinates")
valid_coordinates = [
    "-23, 25",
    "4, -3",
    "24.53525235, 23.45235",
    "04, -23.234235",
    "43.91343345, 143"
]

for coordinate in valid_coordinates:
    test.expect(is_valid_coordinates(coordinate), "%s validation failed." % coordinate)
    
test.it("should return false for invalid coordinates")
invalid_coordinates = [
    "23.234, - 23.4234",
    "2342.43536, 34.324236",
    "N23.43345, E32.6457",
    "99.234, 12.324",
    "6.325624, 43.34345.345",
    "0, 1,2",
    "0.342q0832, 1.2324",
    "23.245, 1e1"
]

for coordinate in invalid_coordinates:
    test.expect(not is_valid_coordinates(coordinate), "%s validation failed." % coordinate)
