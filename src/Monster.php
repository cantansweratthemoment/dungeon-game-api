<?php

class Monster implements Interactive
{
    private $strength;
    private $type;
    static private $strengthRule = array(
        1 => [10, 20, 5],
        2 => [20, 30, 10],
        3 => [30, 40, 15]
    );
    private $isBeaten;
    private $lostPoints;


    public function __construct()
    {
        $this->isBeaten = false;
        $this->strength = rand(Monster::$strengthRule[$this->type][0], Monster::$strengthRule[$this->type][1]);
        $this->lostPoints = Monster::$strengthRule[$this->type][2];//todo вот тут надо переделать будет
    }

    public function interact($character)
    {
        while ($this->strength > 0) {
            $punch = rand(0, 50);//todo хардкодить нехорошо наверное
            if ($punch > $this->strength) {
                $character->increasePoints($this->strength);
                break;
            }
            $this->decreaseStrength($this->lostPoints);
        }
    }

    public function setIsBeaten($isBeaten)
    {
        $this->isBeaten = $isBeaten;
    }


    private function decreaseStrength($subtrahend)
    {
        $this->strength = $this->strength - $subtrahend;
    }
}