<?php


class ExitRoom extends Room
{
    public function __construct($id, $prevConnection, $nextConnection)
    {
        parent::__construct($id, $prevConnection, $nextConnection);
    }

    public function interact($character)
    {
        logger("Персонаж достиг выхода из подземелья.");
    }
    /*Сложный морально-нравственный вопрос, использовать ли тут паттерн синглтон.
Решила что нет, так как чисто теоретически можем в будущем захотеть иметь подземелья с несколькими выходами.*/
}