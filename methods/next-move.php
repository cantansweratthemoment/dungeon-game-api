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
require_once "../entities/WrongCharacterMoveException.php";

$move = (int)$_POST['move'];
$character = unserialize($_SESSION["character"]);
$rooms = unserialize($_SESSION["rooms"]);
$exitId = unserialize($_SESSION["exit-id"]);
try {
    if ($rooms[$character->getCurrentPosition()]->getNextConnection() != $move && $rooms[$character->getCurrentPosition()]->getPrevConnection() != $move) {
        throw new WrongCharacterMoveException(1);
    }
    $character->setCurrentPosition($move);
    echo("Персонаж находится в комнате " . $character->getCurrentPosition() . ".");
    if (!$rooms[$move]->getIsVisited()) {
        $rooms[$move]->interact($character);
        $rooms[$move]->visit();
        if ($move == $exitId) {
            fwrite(fopen("resources/output.json", "w+"), json_encode($character->getPoints()));
            echo("Игра закончена.");
        }
    } else {
        echo("Эта комната уже была посещена.");
    }
} catch (WrongCharacterMoveException $e) {
    echo($e->getMessage());
}
$_SESSION["character"] = serialize($character);
logger("Персонаж помещен в массив сессии.");
$_SESSION["rooms"] = serialize($rooms);
logger("Подземелье помещено в массив сессии.");
$_SESSION["exit-id"] = serialize($exitId);
logger("ID выхода помещен в массив сессии.");