<?php 

require_once("../../../vendor/autoload.php");

use Viber\Client;

$dotenv = Dotenv\Dotenv::create(__DIR__.'/../');
$dotenv->load();


$apiKey = $_ENV['apikey'];
$webhookUrl = $config['webhookUrl']; 

$botSender = new Sender([
    'name' => 'Whois bot',
    'avatar' => 'https://developers.viber.com/img/favicon.ico',
]);

try {
    $client = new Client(['token' => $apiKey]);
    $result = $client->setWebhook($webhookUrl);
    echo "Success!\n"; // print_r($result);
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}

echo $_ENV['host'];