import math

def find_next_square(sq):
    # Return the next square if sq is a square, -1 otherwise
    n = math.sqrt(sq)
    rn = int(n)

    if n == rn:
        return (rn + 1) ** 2

    return -1
