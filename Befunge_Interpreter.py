from random import randint

DIRECTIONS = "><^v"

def interpret(code):
    output = ""
    stack = []
    matrix = code.split("\n")
    y = x = 0
    direction = ">"
    string_mode = False
    char = matrix[y][x]

    # for testing
    step = 0
    auto = True

    while matrix[y][x] != "@":
        if string_mode:
            if char == '"':
                string_mode = False
            else:
                stack.append(ord(char))
        elif char in DIRECTIONS:
            direction = char
        elif ord(char) in range(ord('0'), ord('9') + 1):
            stack.append(int(char))
        elif char == '+':
            stack.append(stack.pop() + stack.pop())
        elif char == '-':
            a = stack.pop()
            b = stack.pop()
            stack.append(b - a)
        elif char == '*':
            stack.append(stack.pop() * stack.pop())
        elif char == '/':
            a = stack.pop()
            b = stack.pop()
            stack.append(0 if a == 0 else int(b / a))
        elif char == '%':
            a = stack.pop()
            b = stack.pop()
            stack.append(0 if a == 0 else b % a)
        elif char == '!':
            stack.append(1 if stack.pop() == 0 else 0)
        elif char == '`':
            a = stack.pop()
            b = stack.pop()
            stack.append(1 if b > a else 0)
        elif char == '?':
            direction = DIRECTIONS[randint(0, 3)]
        elif char == '_':
            num = stack.pop()
            direction = '>' if num == 0 else '<'
        elif char == '|':
            num = stack.pop()
            direction = 'v' if num == 0 else '^'
        elif char == '"':
            string_mode = True
        elif char == ':':
            if len(stack) == 0:
                stack.append(0)
            else:
                num = stack.pop()
                stack.append(num)
                stack.append(num)
        elif char == '\\':
            a = stack.pop()
            b = 0 if len(stack) == 0 else stack.pop()
            stack.append(a)
            stack.append(b)
        elif char == '$':
            stack.pop()
        elif char == '.':
            num = ''
            # while stack:
            num += str(stack.pop())
            output += num
        elif char == ',':
            output += chr(stack.pop())
        elif char == '#':
            (y, x) = advance(y, x, direction, matrix)
        elif char == 'p':
            yy = stack.pop()
            xx = stack.pop()
            vv = stack.pop()
            matrix[yy] = replace_char(matrix[yy], xx, vv)
        elif char == 'g':
            yy = stack.pop()
            xx = stack.pop()
            stack.append(ord(matrix[yy][xx]))
        elif char == ' ':
            pass

        (y, x) = advance(y, x, direction, matrix)
        if x >= len(matrix[y]):
            x = len(matrix[y]) - 1
        char = matrix[y][x]

        # ############## for testing #########
        step += 1
        if step > 120:
            auto = False
        debug(matrix, y, x, direction, stack, output, step, auto)

    return output

def advance(y, x, direction, matrix):
    if direction == '>':
        if x < len(matrix[y]) - 1:
            x += 1
    elif direction == '<':
        if x > 0:
            x -= 1
    elif direction == '^':
        if y > 0:
            y -= 1
    elif direction == 'v':
        if y < len(matrix) - 1:
            y += 1
    return (y, x)

def replace_char(str, at, by):
    return str[0:at] + chr(by) + str[at + 1:]


# ***** Tests *****
from KataTestSuite import Test
test = Test()

import sys
import os
def print_matrix(matrix, y, x):
    os.system('clear')
    for yy in range(len(matrix)):
        for xx in range(len(matrix[yy])):
            if y == yy and x == xx:
                sys.stdout.write("\033[1;31m")
                if matrix[yy][xx] == " ":
                    sys.stdout.write(chr(177))
                else:
                    sys.stdout.write(matrix[yy][xx])
            else:
                sys.stdout.write(matrix[yy][xx])
            if y == yy and x == xx:
                sys.stdout.write("\033[0;0m")
        print ''

def debug (matrix, y, x, direction, stack, output, step, auto = False):
    import time

    if auto:
        time.sleep(0.3)
    else:
        raw_input("Press Enter to continue...")
    print_matrix(matrix, y, x)
    print '-----'
    print "Step: ", step
    print "Line length: ", len(matrix[y])
    print "(y, x): ", y, x
    print "Direction: ", direction
    print "Stack: ", stack
    print "Output: ", output


# test.assert_equals(interpret(''), '')
# test.assert_equals(interpret('64+"!dlroW ,olleH">:#,_@'), "Hello, World!\n")
# test.assert_equals(interpret('>89*35*0p53*0g"X",@'), "H")
# test.assert_equals(interpret('>"!olle"89*,,,,,,@'), "Hello!")
# test.assert_equals(interpret('>987v>.v\nv456<  :\n>321 ^ _@'), '123456789')
# test.assert_equals(interpret('>25*"!dlroW olleH":v\n                v:,_@\n                >  ^'), 'Hello World!\n')
# test.assert_equals(interpret('>              v\nv  ,,,,,"Hello"<\n>48*,          v\nv,,,,,,"World!"<\n>25*,@ '), "Hello World!\n")
# test.assert_equals(interpret('08>:1-:v v *_$.@\n  ^    _$>\:^'), '40320')
# test.assert_equals(interpret('01->1# +# :# 0# g# ,# :# 5# 8# *# 4# +# -# _@'), '01->1# +# :# 0# g# ,# :# 5# 8# *# 4# +# -# _@')
# test.assert_equals(
    # interpret('2>:3g" "-!v\  g30          <\n |!`"O":+1_:.:03p>03g+:"O"`|\n @               ^  p3\" ":<\n2 234567890123456789012345678901234567890123456789012345678901234567890123456789\n'),
    # '2345678910111213141516171819202122232425262728293031323334353637383940414243444546474849505152535455565758596061626364656667686970717273747576777879'
    # )
test.assert_equals(
    interpret('2>:3g" "-!v\  g30          <\n |!`"O":+1_:.:03p>03g+:"O"`|\n @               ^  p3\" ":<\n2 234567890123456789012345678901234567890123456789012345678901234567890123456789\n'),
    '2345678910111213141516171819202122232425262728293031323334353637383940414243444546474849505152535455565758596061626364656667686970717273747576777879'
    )
# test.assert_equals(interpret(''), '')

# Unimplemented &
# test.assert_equals(interpret('2>:3g" "-!v\  g30          <\n |!`"&":+1_:.:03p>03g+:"&"`|\n @               ^  p3\" ":<\n2 2345678901234567890123456789012345678'), '0')
# test.assert_equals(interpret('&>:1-:v v *_$.@\n ^    _$>\:^'), '?')
# test.assert_equals(interpret('>78*vD\nv$_#>vN\n7#!@  A\n3 :v??v\n9,-""""\n4+1ACGT\n+,,""""\n>^^<<<<'), '?')
