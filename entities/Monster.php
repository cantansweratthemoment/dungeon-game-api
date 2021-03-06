<?php
define("MIN_PUNCH", 0);
define("MAX_PUNCH", 100);

class Monster implements Interactive
{
    private $strength;
    private $type;
    static private $strengthRule;
    private $isBeaten;
    private $lostPoints;

    public function __construct($type)
    {
        $this->type = $type;
        $this->isBeaten = false;
        $this->strength = rand(Monster::$strengthRule[$this->type-1][0], Monster::$strengthRule[$this->type-1][1]);
        $this->lostPoints = Monster::$strengthRule[$this->type-1][2];
    }

    public static function setStrengthRule($strengthRule)
    {
        self::$strengthRule = $strengthRule;
    }

    public function interact($character)
    {
        echo("Начальная сила монстра: " . $this->strength);
        while ($this->strength > 0) {
            $punch = rand(MIN_PUNCH, MAX_PUNCH);
            echo("Монстру наносится урон величины " . $punch . ".");
            if ($this->takeHit($punch)) {
                $character->increasePoints($this->strength);
                break;
            } else {
                $this->decreaseStrength($this->lostPoints);
                echo("Сила монстра уменьшена на " . $this->lostPoints . ".");
            }
        }
        echo("Монстр побежден.");
    }

    public function takeHit($punch)
    {
        if ($punch > $this->strength) {
            return true;
        } else {
            return false;
        }
    }

    public
    function setIsBeaten($isBeaten)
    {
        $this->isBeaten = $isBeaten;
    }


    private
    function decreaseStrength($subtrahend)
    {
        $this->strength = $this->strength - $subtrahend;
    }
}