<?php
require_once "Character.php";
require_once "EmptyRoom.php";
require_once "Chest.php";
require_once "RoomWithChest.php";
require_once "Monster.php";
require_once "RoomWithMonster.php";
function logger($message)
{
    $log_dirname = 'logs';
    if (!file_exists($log_dirname)) {
        mkdir($log_dirname, 0777, true);
    }
    $log_file_data = $log_dirname . '/log_' . date('d-M-Y') . '.log';
    file_put_contents($log_file_data, $message . "\n", FILE_APPEND);
}

$characterMoves = json_decode(file_get_contents("resources/character-moves.json"), true);
$character = new Character();
logger("Создан персонаж.");
$character->setCurrentPosition($characterMoves[0]);
logger("Позиция персонажа: " . $character->getCurrentPosition() . ".");
$entitiesInfo = json_decode(file_get_contents("resources/entities-info.json"), true);
$character->setPoints($entitiesInfo["start-points"]);
logger("Количество очков персонажа: " . $character->getPoints() . ".");
Chest::setRarityRule($entitiesInfo["rarity-rule"]);
Monster::setStrengthRule($entitiesInfo["strength-rule"]);
$dungeonInfo = json_decode(file_get_contents("resources/dungeon-info.json"), true);
$rooms = array();
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

    }
}
logger("Создано подземелье.");
foreach ($characterMoves as $id) {
    $character->setCurrentPosition($id);
    logger("Персонаж находится в комнате " . $character->getCurrentPosition() . ".");
    if (!$rooms[$id]->getIsVisited()) {
        $rooms[$id]->interact($character);
        $rooms[$id]->visit();
    } else {
        logger("Эта комната уже была посещена.");
    }
}
fwrite(fopen("resources/output.json", "w+"), json_encode($character->getPoints()));
//todo обработать исключения
//todo дождаться ответа что такое выход