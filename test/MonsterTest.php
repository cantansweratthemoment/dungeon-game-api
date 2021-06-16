<?php
require_once "/dungeon-game-api/src/Interactive.php";
require_once "/dungeon-game-api/src/Monster.php";

use PHPUnit\Framework\TestCase;

class MonsterTest extends TestCase
{
    public function testTakeHit()
    {
        Monster::setStrengthRule([1 => [0, 10], 2 => [10, 20], 3 => [20, 30]]);
        $monster = new Monster(2);
        $punchHard = 25;
        $punchEasy = 5;
        self::assertTrue($monster->takeHit($punchHard));
        self::assertFalse($monster->takeHit($punchEasy));
    }
}
