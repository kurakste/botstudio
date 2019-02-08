<?php 
ini_set('error_reporting', E_ALL);

require_once("../../../vendor/autoload.php");

use Viber\Client;

$dotenv = Dotenv\Dotenv::create(__DIR__.'/../');
$dotenv->load();


$apiKey = $_ENV['apikey'];
$webhookUrl = $_ENV['webhookurl']; 

try {
    $client = new Client(['token' => $apiKey]);
    $result = $client->setWebhook($webhookUrl);
    echo "Success!\n"; // print_r($result);
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}
