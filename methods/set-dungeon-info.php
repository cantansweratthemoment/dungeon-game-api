<?php
include_once "../utils/logger.php";
$dungeonInfo = json_decode($_POST["dungeon-info"], true);
logger("Получены данные о подземелье.");
file_put_contents("../resources/dungeon-info.json", json_encode($dungeonInfo));
logger("Данные о подземелье сохранены в файл.");
