<?php
require_once "Room.php";

class EmptyRoom extends Room
{
    public function __construct($id, $prevConnection, $nextConnection)
    {
        parent::__construct($id, $prevConnection, $nextConnection);
    }

    public function interact($character)
    {
        echo("Эта комната пустая.");
    }

}