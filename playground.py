def replace_char(str, at, by):
    return str[0:at] + by + str[at + 1:]

print replace_char("0123456", 3, 'x')