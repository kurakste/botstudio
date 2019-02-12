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
    'avatar' => __DIR__.'/../img/avatar.png',
]);

// log bot interaction
$log = new Logger('bot');
$log->pushHandler(new StreamHandler('/tmp/bot.log'));

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
            return (new \Viber\Api\Message\Text())
                ->setSender($botSender)
                ->setText("Hi, you can see some demo: send 'k1' or 'k2' etc.");
        })
        // when user subscribe to PA
        ->onSubscribe(function ($event) use ($bot, $botSender, $log) {
            $log->info('onSubscribe handler');
            $this->getClient()->sendMessage(
                (new \Viber\Api\Message\Text())
                    ->setSender($botSender)
                    ->setText('Thanks for subscription!')
            );
        })
        ->onText('|начать|s', function ($event) use ($bot, $botSender, $log, $storage) {
            $log->info('onStart' . $event->getMessage()->getText());
            $str = require_once(__DIR__.'/../messages/greeting.php');
            $bot->getClient()->sendMessage(
                (new \Viber\Api\Message\Text())
                    ->setTrackingData($str)
                    ->setSender($botSender)
                    ->setReceiver($event->getSender()->getId())
                    ->setText($str)
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
        ->onText('|usecases|s', function ($event) use ($bot, $botSender, $log, $storage) {
            $log->info('usecases method:');
            $kbrd = require_once(__DIR__.'/../keyboards/uscases.php');
            $log->info('usecases method:');
            $str = file_get_contents(__DIR__.'/../messages/vars.txt');
            $bot->getClient()->sendMessage(
                (new \Viber\Api\Message\Text())
                    ->setSender($botSender)
                    ->setReceiver($event->getSender()->getId())
                    ->setText($str)
                    ->setKeyboard($kbrd)
            );
        })
        ->onText('|benefits|s', function ($event) use ($bot, $botSender, $log, $storage) {
            $log->info('benefits method:');
            $kbrd = require_once(__DIR__.'/../keyboards/benifits.php');
            $log->info('usecases method:');
            $str = file_get_contents(__DIR__.'/../messages/benefits.txt');
            $bot->getClient()->sendMessage(
                (new \Viber\Api\Message\Text())
                    ->setSender($botSender)
                    ->setReceiver($event->getSender()->getId())
                    ->setText($str)
                    ->setKeyboard($kbrd)
            );
        })
        ->onText('|connectors|s', function ($event) use ($bot, $botSender, $log, $storage) {
            $log->info('connectors method:');
            $kbrd = require_once(__DIR__.'/../keyboards/connectors.php');
            $log->info('usecases method:');
            $str = file_get_contents(__DIR__.'/../messages/connectors.txt');
            $bot->getClient()->sendMessage(
                (new \Viber\Api\Message\Text())
                    ->setSender($botSender)
                    ->setReceiver($event->getSender()->getId())
                    ->setText($str)
                    ->setKeyboard($kbrd)
            );
        })
        ->onText('|effectually|s', function ($event) use ($bot, $botSender, $log, $storage) {
            $log->info('effectually method:');
            $kbrd = require_once(__DIR__.'/../keyboards/effectually.php');
            $log->info('usecases method:');
            $str = file_get_contents(__DIR__.'/../messages/effectually.txt');
            $bot->getClient()->sendMessage(
                (new \Viber\Api\Message\Text())
                    ->setSender($botSender)
                    ->setReceiver($event->getSender()->getId())
                    ->setText($str)
                    ->setKeyboard($kbrd)
            );
        })
        ->onText('|prices|s', function ($event) use ($bot, $botSender, $log, $storage) {
            $log->info('prices method:');
            $kbrd = require_once(__DIR__.'/../keyboards/mainMenu.php');
            $log->info('usecases method:');
            $str = file_get_contents(__DIR__.'/../messages/prices.txt');
            $bot->getClient()->sendMessage(
                (new \Viber\Api\Message\Text())
                    ->setSender($botSender)
                    ->setReceiver($event->getSender()->getId())
                    ->setText($str)
                    ->setKeyboard($kbrd)
            );
        })
        ->onText('|callback|s', function ($event) use ($bot, $botSender, $log, $storage) {
            $log->info('prices method:');
            $kbrd = require_once(__DIR__.'/../keyboards/mainMenu.php');
            $log->info('usecases method:');
            $str = file_get_contents(__DIR__.'/../messages/callback.txt');
            $bot->getClient()->sendMessage(
                (new \Viber\Api\Message\Text())
                    ->setSender($botSender)
                    ->setReceiver($event->getSender()->getId())
                    ->setText($str)
                    ->setKeyboard($kbrd)
            );
        })
        ->onText('|clear|s', function ($event) use ($bot, $botSender, $log, $storage) {
            $log->info('onClear' . $event->getMessage()->getText());
            $str = $event->getMessage()->getTrackingData();
            $log->info('Tracking data:'.$str);
            $str = '';
            // .* - match any symbols
            $bot->getClient()->sendMessage(
                (new \Viber\Api\Message\Text())
                    ->setTrackingData($str)
                    ->setSender($botSender)
                    ->setReceiver($event->getSender()->getId())
                    ->setText('Yes, MyCap')
            );
        })
        ->onText('|.*|s', function ($event) use ($bot, $botSender, $log, $storage) {
            $storage->logMessageToDb(
                "botseller",
                $event->getMessage()->getText(),
                $event->getSender()->getId(),
                "botseller",
                $event->getMessage()->getTrackingData()
            );

            $joke = require_once(__DIR__.'/../skills/humor/gethummor.php');
            $log->info('onText ' . $joke);
            $str = "К сожалению я вас не понимаю. Давайте я вам анекдот расскажу: \n";
            $str = $str.$joke;
            $kbrd = require_once(__DIR__.'/../keyboards/mainMenu.php');

            $storage->logMessageToDb(
                "botseller",
                $str,
                "botseller",
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
