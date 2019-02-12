<?php 

require __DIR__ . '/../../../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::create(__DIR__.'/../');
$dotenv->load();

$a = $_ENV['host'];

echo "HI! a = {$a} <br>";