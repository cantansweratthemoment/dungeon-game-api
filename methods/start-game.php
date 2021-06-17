<?php
require_once "../entities/Character.php";
require_once "../entities/EmptyRoom.php";
require_once "../entities/Chest.php";
require_once "../entities/RoomWithChest.php";
require_once "../entities/Monster.php";
require_once "../entities/RoomWithMonster.php";
require_once "../entities/ExitRoom.php";
require_once "../entities/WrongCharacterMoveException.php";
include_once "../utils/logger.php";
$firstMove = (int)$_POST['first-move'];
logger("Получено начальное положение персонажа.");
$character = new Character();
$character->setCurrentPosition($firstMove);
logger("Создан персонаж");
$entitiesInfo = json_decode(file_get_contents("../resources/entities-info.json"), true);
$character->setPoints($entitiesInfo["start-points"]);
logger("Количество очков персонажа: " . $character->getPoints() . ".\n");
Chest::setRarityRule($entitiesInfo["rarity-rule"]);
Monster::setStrengthRule($entitiesInfo["strength-rule"]);
logger("Установлены правила соответствия типов для монстров и сундуков.");
$dungeonInfo = json_decode(file_get_contents("../resources/dungeon-info.json"), true);
$rooms = array();
$exitId = -1;
foreach ($dungeonInfo as $currentRoom) {
    switch ($currentRoom["type"]) {
        case "empty":
            $newRoom = new EmptyRoom($currentRoom["id"], $currentRoom["prev-connection"], $currentRoom["next-connection"]);
            $rooms[$currentRoom["id"]] = $newRoom;
            break;
        case "with-chest":
            $chest = new Chest($currentRoom["chest"]["type"]);
            $newRoom = new RoomWithChest($currentRoom["id"], $currentRoom["prev-connection"], $currentRoom["next-connection"], $chest);
            $rooms[$currentRoom["id"]] = $newRoom;
            break;
        case "with-monster":
            $monster = new Monster($currentRoom["monster"]["type"]);
            $newRoom = new RoomWithMonster($currentRoom["id"], $currentRoom["prev-connection"], $currentRoom["next-connection"], $monster);
            $rooms[$currentRoom["id"]] = $newRoom;
            break;
        case "exit":
            $newRoom = new ExitRoom($currentRoom["id"], $currentRoom["prev-connection"], $currentRoom["next-connection"]);
            $rooms[$currentRoom["id"]] = $newRoom;
            $exitId = $currentRoom["id"];
            break;
    }
}
logger("Создано подземелье.\n");
echo("Персонаж находится в комнате " . $character->getCurrentPosition() . ".");
if (!$rooms[$firstMove]->getIsVisited()) {
    $rooms[$firstMove]->interact($character);
    $rooms[$firstMove]->visit();
    if ($firstMove == $exitId) {
        fwrite(fopen("resources/output.json", "w+"), json_encode($character->getPoints()));
        echo("Игра закончена.");
    }
} else {
    echo("Эта комната уже была посещена.");
}
$_SESSION["character"] = serialize($character);
logger("Персонаж помещен в массив сессии.");
$_SESSION["rooms"] = serialize($rooms);
logger("Подземелье помещено в массив сессии.");
$_SESSION["exit-id"] = serialize($exitId);
logger("ID выхода помещен в массив сессии.");