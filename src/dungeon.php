<?php
require_once "Character.php";
require_once "EmptyRoom.php";
require_once "Chest.php";
require_once "RoomWithChest.php";
$characterMoves = json_decode(file_get_contents("resources/character-moves.json"), true);
$character = new Character();
$character->setCurrentPosition($characterMoves[0]);
$dungeonInfo = json_decode(file_get_contents("resources/dungeon-info.json", true));
$rooms = array();
foreach ($dungeonInfo as $currentRoom) {
    switch ($currentRoom->type) {
        case "empty":
            $newRoom = new EmptyRoom();
            $rooms[$currentRoom->id] = $newRoom;
            break;
        case "with-chest":
            $chest = new Chest($currentRoom->chest->type);
            $newRoom = new RoomWithChest($currentRoom->id, $currentRoom->connection, $chest);
            $rooms[$currentRoom->id] = $newRoom;
            break;
        case "with-monster":
            $newRoom = new RoomWithMonster();
            break;

    }
    var_dump($rooms);
}
//todo логи