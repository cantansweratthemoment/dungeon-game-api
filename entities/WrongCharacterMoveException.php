<?php


class WrongCharacterMoveException extends Exception
{
    public function __construct($code)
    {
        parent::__construct("Последовательность шагов персонажа некорректна!", $code);
    }
}