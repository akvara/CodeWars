class Node(object):
    def __init__(self):
        self.next = None

def loop_size(node):
    chain = []
    count = 0
    while id(node) not in chain:
        chain += [id(node)]
        count += 1
        node = node.next
    return count - chain.index(id(node))


from KataTestSuite import Test
test = Test()


# Make a short chain with a loop of 3
node1 = Node()
node2 = Node()
node3 = Node()
node4 = Node()
node1.next = node2
node2.next = node3
node3.next = node4
node4.next = node2

test.assert_equals(loop_size(node1), 3, 'Loop size of 3 expected')

# Make a longer chain with a loop of 29
nodes = [Node() for _ in xrange(50)]
for node, next_node in zip(nodes, nodes[1:]):
    node.next = next_node
nodes[49].next = nodes[21]
test.assert_equals(loop_size(nodes[0]), 29, 'Loop size of 29 expected')

# Make a very long chain with a loop of 1087
# chain = create_chain(3904, 1087)
# test.assert_equals(loop_size(chain), 1087, 'Loop size of 1087 expected')