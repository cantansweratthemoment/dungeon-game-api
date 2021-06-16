<?php
require_once "Interactive.php";

abstract class Room implements Interactive
{
    protected $id;
    protected $prevConnection;
    protected $nextConnection;
    protected $isVisited;

    abstract public function interact($character);

    public function visit()
    {
        $this->isVisited = true;
    }

    public function __construct($id, $prevConnection, $nextConnection)
    {
        $this->prevConnection = $prevConnection;
        $this->nextConnection = $nextConnection;
        $this->id = $id;
        $this->isVisited = false;
    }

    public function getIsVisited()
    {
        return $this->isVisited;
    }
}