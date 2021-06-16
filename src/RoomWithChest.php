<?php

class RoomWithChest extends Room
{
    private $chest;

    public function interact($character)
    {
        $this->chest->interact($character);
        $this->chest->setIsOpened(true);
    }

    public function __construct($id, $connection, $chest)
    {
        $this->connection = $connection;
        $this->id = $id;
        $this->chest = $chest;
        $this->isVisited = false;
    }
}