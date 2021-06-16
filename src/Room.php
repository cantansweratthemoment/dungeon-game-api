<?php
require_once "Interactive.php";
abstract class Room implements Interactive
{
    protected $id;
    protected $connection;
    protected $isVisited;

    protected function changeVisited()
    {
        $this->isVisited = !$this->isVisited;
    }

    abstract function interact($character);
    public function __construct()
    {
        $this->isVisited=false;
    }
}