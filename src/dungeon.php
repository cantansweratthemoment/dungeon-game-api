<?php
require_once "Character.php";
require_once "EmptyRoom.php";
require_once "Chest.php";
require_once "RoomWithChest.php";
require_once "Monster.php";
require_once "RoomWithMonster.php";
require_once "ExitRoom.php";
require_once "WrongCharacterMoveException.php";
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
$flagFirstPosition = true;//маленький костыль чтобы не выбрасывать исключение на первой позиции
$entitiesInfo = json_decode(file_get_contents("resources/entities-info.json"), true);
$character->setPoints($entitiesInfo["start-points"]);
logger("Количество очков персонажа: " . $character->getPoints() . ".\n");
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
        case "exit":
            $newRoom = new ExitRoom($currentRoom["id"], $currentRoom["prev-connection"], $currentRoom["next-connection"]);
            $rooms[$currentRoom["id"]] = $newRoom;
            $exitId = $currentRoom["id"];
            break;
    }
}
logger("Создано подземелье.\n");
foreach ($characterMoves as $id) {
    try {
        if ($rooms[$character->getCurrentPosition()]->getNextConnection() != $id && $rooms[$character->getCurrentPosition()]->getPrevConnection() != $id && !$flagFirstPosition) {
            throw new WrongCharacterMoveException(1);
        }
        $character->setCurrentPosition($id);
        logger("Персонаж находится в комнате " . $character->getCurrentPosition() . ".");
        if (!$rooms[$id]->getIsVisited()) {
            $flagFirstPosition = false;
            $rooms[$id]->interact($character);
            $rooms[$id]->visit();
            if ($id == $exitId) {
                fwrite(fopen("resources/output.json", "w+"), json_encode($character->getPoints()));
                logger("Игра закончена.");
                break;
            }
        } else {
            logger("Эта комната уже была посещена.");
        }
        logger("");
    } catch (WrongCharacterMoveException $e) {
        echo($e->getMessage());
        break;
    }
}