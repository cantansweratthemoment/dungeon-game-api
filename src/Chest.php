<?php

class Chest implements Interactive
{
    private $rarity;
    static private $rarityRule;
    private $min, $max;
    private $isOpened;

    public function interact($character)
    {
        if (!$this->isOpened) {
            logger("Сундук открылся.");
            $givenPoints = rand($this->min, $this->max);
            logger("Полученное количество очков от сундука: " . $givenPoints);
            $character->increasePoints($givenPoints);
        }
    }

    public function setIsOpened($isOpened)
    {
        $this->isOpened = $isOpened;
    }

    public static function setRarityRule($rarityRule)
    {
        self::$rarityRule = $rarityRule;
    }

    public function __construct($rarity)
    {
        $this->rarity = $rarity;
        $this->isOpened = false;
        $this->min = Chest::$rarityRule[$this->rarity - 1][0];
        $this->max = Chest::$rarityRule[$this->rarity - 1][1];
    }
}