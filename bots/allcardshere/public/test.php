<?php

require_once("../../../vendor/autoload.php");

$dotenv = Dotenv\Dotenv::create(__DIR__.'/../');
$dotenv->load();

use app\botseller\services\Storage;
$pdo = $_ENV['pdo'];
$dbusername = $_ENV['dbusername'];
$dbpassword = $_ENV['dbpassword'];

$storage = new Storage($pdo, $dbusername, $dbpassword);
$storage->logMessageToDb("xxx0077", "this is message!", "yyy0088", "zzz0099", "fucking context !!!");

Storage::getMessage();