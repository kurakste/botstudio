<?php
require_once("../../../vendor/autoload.php");

use Viber\Bot;
use Viber\Api\Sender;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use app\botseller\services\Storage;

$dotenv = Dotenv\Dotenv::create(__DIR__.'/../');
$dotenv->load();

$apiKey = $_ENV['apikey'];

$botSender = new Sender([
    'name' => 'BotSeller',
    'avatar' => $_SERVER['SERVER_NAME'].'/bots/allcardshere/img/avatar.png',
]);
// log bot interaction
$log = new Logger('bot_allcardshere');
$log->pushHandler(new StreamHandler('/tmp/bot_allcardshere.log'));

$pdo = $_ENV['pdo'];
$dbusername = $_ENV['dbusername'];
$dbpassword = $_ENV['dbpassword'];
$storage = new Storage($pdo, $dbusername, $dbpassword);

try {
    // create bot instance
    $bot = new Bot(['token' => $apiKey]);
    $bot
        // first interaction with bot - return "welcome message"
        ->onConversation(function ($event) use ($bot, $botSender, $log) {
            $log->info('onConversation handler');
            $kbrd = require_once(__DIR__.'/../keyboards/mainMenu.php');
            $str = require_once(__DIR__.'/../messages/greeting.php');
            return (new \Viber\Api\Message\Text())
                ->setSender($botSender)
                ->setText($str)
                ->setKeyboard($kbrd);
        })
        // when user subscribe to PA
        ->onSubscribe(function ($event) use ($bot, $botSender, $log) {
            $log->info('onSubscribe handler');
            $kbrd = require_once(__DIR__.'/../keyboards/mainMenu.php');
            $str = require_once(__DIR__.'/../messages/greeting.php');
            $this->getClient()->sendMessage(
                (new \Viber\Api\Message\Text())
                    ->setSender($botSender)
                    ->setText($str)
                    ->setKeyboard($kbrd)
            );
        })
        ->onText('|menu|s', function ($event) use ($bot, $botSender, $log, $storage) {
            $kbrd = require_once(__DIR__.'/../keyboards/mainMenu.php');
            $log->info('menu method:');
            $str = require_once(__DIR__.'/../messages/greeting.php');
            $bot->getClient()->sendMessage(
                (new \Viber\Api\Message\Text())
                    ->setSender($botSender)
                    ->setReceiver($event->getSender()->getId())
                    ->setText($str)
                    ->setKeyboard($kbrd)
            );
        })
        ->onText("/metro|метро/ius", function ($event) use ($bot, $botSender, $log, $storage) {
            $log->info('onClear' . $event->getMessage()->getText());
            $kbrd = require_once(__DIR__.'/../keyboards/mainMenu.php');
            $bot->getClient()->sendMessage(
                (new \Viber\Api\Message\Picture())
                    ->setSender($botSender)
                    ->setReceiver($event->getSender()->getId())
                    ->setText('Дайте отсканировать эту карту кассиру')
                    ->setMedia($_SERVER['SERVER_NAME'].'/bots/allcardshere/img/avatar.png')
                    ->setThumbnail($_SERVER['SERVER_NAME'].'/bots/allcardshere/img/avatar.png')
                    ->setKeyboard($kbrd)
            );
        })

        ->onText('|.*|s', function ($event) use ($bot, $botSender, $log, $storage) {
            $storage->logMessageToDb(
                "allcardshere",
                $event->getMessage()->getText(),
                $event->getSender()->getId(),
                "allcardshere",
                $event->getMessage()->getTrackingData()
            );

            $joke = require_once(__DIR__.'/../skills/humor/gethummor.php');
            $log->info('onText ' . $joke);
            $str = "К сожалению я вас не понимаю. Давайте я вам анекдот расскажу: \n";
            $str = $str.$joke;
            $kbrd = require_once(__DIR__.'/../keyboards/mainMenu.php');

            $storage->logMessageToDb(
                "allcardshere",
                $str,
                "allcardshere",
                $event->getSender()->getId(),
                $event->getMessage()->getTrackingData()
            );

            $bot->getClient()->sendMessage(
                (new \Viber\Api\Message\Text())
                    ->setTrackingData($str)
                    ->setSender($botSender)
                    ->setReceiver($event->getSender()->getId())
                    ->setText($str)
                    ->setKeyboard($kbrd)
            );
        })
        ->run();
} catch (Exception $e) {
    $log->warning('Exception: ' . $e->getMessage());
    if ($bot) {
        $log->warning('Actual sign: ' . $bot->getSignHeaderValue());
        $log->warning('Actual body: ' . $bot->getInputBody());
    }
}
