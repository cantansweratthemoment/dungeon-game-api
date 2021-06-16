<?php

class Chest implements Interactive
{
    private $rarity;//todo можно брать информацию о диапазонах тоже из инпута
    static private $rarityRule = array(
        1 => [10, 20],
        2 => [20, 30],
        3 => [30, 40]
    );
    private $min, $max;
    private $isOpened;

    public function interact($character)
    {
        if (!$this->isOpened) {
            $givenPoints = rand($this->min, $this->max);
            $character->increasePoints($givenPoints);
        }
    }

    public function setIsOpened($isOpened)
    {
        $this->isOpened = $isOpened;
    }

    public function __construct($rarity)
    {
        $this->rarity = $rarity;
        $this->isOpened = false;
        $this->min = Chest::$rarityRule[$this->rarity][0];
        $this->max = Chest::$rarityRule[$this->rarity][1];
    }
}