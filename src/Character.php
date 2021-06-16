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
    }

    public function decreasePoints($addition)
    {
        if ($addition <= $this->points) {
            $this->points = $this->points + $addition;
        } else {
            $this->points = 0;
        }
    }

    public function setCurrentPosition($currentPosition)
    {
        $this->currentPosition = $currentPosition;
    }

    public function getCurrentPosition()
    {
        return $this->currentPosition;
    }

}