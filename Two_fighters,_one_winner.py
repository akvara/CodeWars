def after_attack(fighter, attacker_name, damage):
    if attacker_name == fighter.name:
        return fighter

    fighter.health -= damage
    return fighter

def declare_winner(fighter1, fighter2, first_attacker):
    attacker_name = first_attacker

    while True:
        fighter1 = after_attack(fighter1, attacker_name, fighter2.damage_per_attack)
        if fighter1.health <= 0:
            return fighter2.name

        fighter2 = after_attack(fighter2, attacker_name, fighter1.damage_per_attack)
        if fighter2.health <= 0:
            return fighter1.name

        if attacker_name == fighter1.name:
            attacker_name = fighter2.name
        else:
            attacker_name = fighter1.name



class Fighter(object):
    def __init__(self, name, health, damage_per_attack):
        self.name = name
        self.health = health
        self.damage_per_attack = damage_per_attack



from KataTestSuite import Test
test = Test()


# Example test cases

test.describe("Example test cases")

test.assert_equals(declare_winner(Fighter("Lew", 10, 2),Fighter("Harry", 5, 4), "Lew"), "Lew")

test.assert_equals(declare_winner(Fighter("Lew", 10, 2),Fighter("Harry", 5, 4), "Harry"),"Harry")

test.assert_equals(declare_winner(Fighter("Harald", 20, 5), Fighter("Harry", 5, 4), "Harry"),"Harald")

test.assert_equals(declare_winner(Fighter("Harald", 20, 5), Fighter("Harry", 5, 4), "Harald"),"Harald")

test.assert_equals(declare_winner(Fighter("Jerry", 30, 3), Fighter("Harald", 20, 5), "Jerry"), "Harald")

test.assert_equals(declare_winner(Fighter("Jerry", 30, 3), Fighter("Harald", 20, 5), "Harald"),"Harald")