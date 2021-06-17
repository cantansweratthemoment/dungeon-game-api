<?php

class RoomWithChest extends Room
{
    private $chest;

    public function interact($character)
    {
        echo("Происходит взаимодействие с сундуком.");
        $this->chest->interact($character);
        $this->chest->setIsOpened(true);
    }

    public function __construct($id, $prevConnection, $nextConnection, $chest)
    {
        parent::__construct($id, $prevConnection, $nextConnection);
        $this->chest = $chest;
    }
}