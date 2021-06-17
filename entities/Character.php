<?php

class Character
{
    private $points;
    private $currentPosition;

    public function __construct()
    {
        $this->points = 0;
    }

    public function getPoints()
    {
        return $this->points;
    }

    public function increasePoints($addition)
    {
        $this->points = $this->points + $addition;
        echo("Количество очков персонажа увеличено на " . $addition . ". Новое значение очков: " . $this->getPoints() . ".");
    }

    public function decreasePoints($addition)
    {
        if ($addition <= $this->points) {
            $this->points = $this->points + $addition;
            echo("Количество очков персонажа уменьшено на " . $addition . ". Новое значение очков: " . $this->getPoints() . ".");
        } else {
            $this->points = 0;
            echo("Новое значение очков персонажа: 0.");
        }
    }

    public function setCurrentPosition($currentPosition)
    {
        $this->currentPosition = $currentPosition;
    }

    public function setPoints($points)
    {
        $this->points = $points;
    }

    public function getCurrentPosition()
    {
        return $this->currentPosition;
    }

}