<?php 

require_once("../../../vendor/autoload.php");

use Viber\Client;

$dotenv = Dotenv\Dotenv::create(__DIR__.'/../');
$dotenv->load();


$apiKey = $_ENV['apikey'];
$webhookUrl = $_ENV['webhookurl']; 

// echo $apiKey; die;
echo $webhookUrl; die;

$botSender = new Sender([
    'name' => 'BotSeller',
    'avatar' => __DIR__.'/../img/avatar.png',
]);

try {
    $client = new Client(['token' => $apiKey]);
    $result = $client->setWebhook($webhookUrl);
    echo "Success!\n"; // print_r($result);
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}
