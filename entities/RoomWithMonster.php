<?php

class RoomWithMonster extends Room
{
    private $monster;

    public function interact($character)
    {
        echo("Происходит взаимодействие с монстром.");
        $this->monster->interact($character);
        $this->monster->setIsBeaten(true);
    }

    public function __construct($id, $prevConnection, $nextConnection, $monster)
    {
        parent::__construct($id, $prevConnection, $nextConnection);
        $this->monster = $monster;
    }
}