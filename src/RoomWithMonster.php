<?php

class RoomWithMonster extends Room
{
    private $monster;

    function interact($character)
    {
        $this->monster->interact($character);
        $this->monster->setIsBeaten(true);
    }
}