<?php
include_once "../utils/logger.php";
$entitiesInfo = json_decode($_POST["entities-info"], true);
logger("Получены данные об игровых сущностях.");
file_put_contents("../resources/entities-info.json", json_encode($entitiesInfo));
logger("Данные об игровых сущностях сохранены в файл.");