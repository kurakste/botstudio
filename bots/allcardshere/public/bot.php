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
    'name' => 'Masha',
    'avatar' => 'https://'.$_SERVER['SERVER_NAME'].'/bots/allcardshere/img/avatar.png',
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

        ->onText("/agat|агат/ius", function ($event) use ($bot, $botSender, $log, $storage) {
            $log->info('agat:' . $event->getMessage()->getText());
            $kbrd = require_once(__DIR__.'/../keyboards/mainMenu.php');
            $bot->getClient()->sendMessage(
                (new \Viber\Api\Message\Text())
                    ->setSender($botSender)
                    ->setReceiver($event->getSender()->getId())
                    ->setText('Эта сеть использует карты с магнитной лентой :-(')
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
                    ->setMedia('https://'.$_SERVER['SERVER_NAME'].'/bots/allcardshere/img/cards/metro.jpeg')
                    ->setKeyboard($kbrd)
            );
        })
        ->onText("/lenta|лента/ius", function ($event) use ($bot, $botSender, $log, $storage) {
            $log->info('onClear' . $event->getMessage()->getText());
            $kbrd = require_once(__DIR__.'/../keyboards/mainMenu.php');
            $bot->getClient()->sendMessage(
                (new \Viber\Api\Message\Picture())
                    ->setSender($botSender)
                    ->setReceiver($event->getSender()->getId())
                    ->setText('Дайте отсканировать эту карту кассиру')
                    ->setMedia('https://'.$_SERVER['SERVER_NAME'].'/bots/allcardshere/img/cards/lenta.jpeg')
                    ->setKeyboard($kbrd)
            );
        })
        
        ->onText("/перек|перекресток/ius", function ($event) use ($bot, $botSender, $log, $storage) {
            $log->info('onClear' . $event->getMessage()->getText());
            $kbrd = require_once(__DIR__.'/../keyboards/mainMenu.php');
            $bot->getClient()->sendMessage(
                (new \Viber\Api\Message\Picture())
                    ->setSender($botSender)
                    ->setReceiver($event->getSender()->getId())
                    ->setText('Дайте отсканировать эту карту кассиру')
                    ->setMedia('https://'.$_SERVER['SERVER_NAME'].'/bots/allcardshere/img/cards/perek.jpeg')
                    ->setKeyboard($kbrd)
            );
        })
        
        ->onText("/decatlon|декатлон/ius", function ($event) use ($bot, $botSender, $log, $storage) {
            $log->info('onClear' . $event->getMessage()->getText());
            $kbrd = require_once(__DIR__.'/../keyboards/mainMenu.php');
            $bot->getClient()->sendMessage(
                (new \Viber\Api\Message\Picture())
                    ->setSender($botSender)
                    ->setReceiver($event->getSender()->getId())
                    ->setText('Дайте отсканировать эту карту кассиру')
                    ->setMedia('https://'.$_SERVER['SERVER_NAME'].'/bots/allcardshere/img/cards/decatlon.jpeg')
                    ->setKeyboard($kbrd)
            );
        })
        
        ->onText("/fixprice|фикспрайс/ius", function ($event) use ($bot, $botSender, $log, $storage) {
            $log->info('onClear' . $event->getMessage()->getText());
            $kbrd = require_once(__DIR__.'/../keyboards/mainMenu.php');
            $bot->getClient()->sendMessage(
                (new \Viber\Api\Message\Picture())
                    ->setSender($botSender)
                    ->setReceiver($event->getSender()->getId())
                    ->setText('Дайте отсканировать эту карту кассиру')
                    ->setMedia('https://'.$_SERVER['SERVER_NAME'].'/bots/allcardshere/img/cards/fixprice.jpeg')
                    ->setKeyboard($kbrd)
            );
        })
        
        ->onText("/karusel|карусель|карусел/ius", function ($event) use ($bot, $botSender, $log, $storage) {
            $log->info('onClear' . $event->getMessage()->getText());
            $kbrd = require_once(__DIR__.'/../keyboards/mainMenu.php');
            $bot->getClient()->sendMessage(
                (new \Viber\Api\Message\Picture())
                    ->setSender($botSender)
                    ->setReceiver($event->getSender()->getId())
                    ->setText('Дайте отсканировать эту карту кассиру')
                    ->setMedia('https://'.$_SERVER['SERVER_NAME'].'/bots/allcardshere/img/cards/karusel.jpeg')
                    ->setKeyboard($kbrd)
            );
        })

        ->onText("/kib|киб|красное и белое/ius", function ($event) use ($bot, $botSender, $log, $storage) {
            $log->info('onClear' . $event->getMessage()->getText());
            $kbrd = require_once(__DIR__.'/../keyboards/mainMenu.php');
            $bot->getClient()->sendMessage(
                (new \Viber\Api\Message\Picture())
                    ->setSender($botSender)
                    ->setReceiver($event->getSender()->getId())
                    ->setText('Дайте отсканировать эту карту кассиру')
                    ->setMedia('https://'.$_SERVER['SERVER_NAME'].'/bots/allcardshere/img/cards/kib.jpeg')
                    ->setKeyboard($kbrd)
            );
        })

        ->onText("/miratorg|мираторг/ius", function ($event) use ($bot, $botSender, $log, $storage) {
            $log->info('onClear' . $event->getMessage()->getText());
            $kbrd = require_once(__DIR__.'/../keyboards/mainMenu.php');
            $bot->getClient()->sendMessage(
                (new \Viber\Api\Message\Picture())
                    ->setSender($botSender)
                    ->setReceiver($event->getSender()->getId())
                    ->setText('Дайте отсканировать эту карту кассиру')
                    ->setMedia('https://'.$_SERVER['SERVER_NAME'].'/bots/allcardshere/img/cards/miratorg.jpeg')
                    ->setKeyboard($kbrd)
            );
        })

        ->onText("/obi|оби/ius", function ($event) use ($bot, $botSender, $log, $storage) {
            $log->info('onClear' . $event->getMessage()->getText());
            $kbrd = require_once(__DIR__.'/../keyboards/mainMenu.php');
            $bot->getClient()->sendMessage(
                (new \Viber\Api\Message\Picture())
                    ->setSender($botSender)
                    ->setReceiver($event->getSender()->getId())
                    ->setText('Дайте отсканировать эту карту кассиру')
                    ->setMedia('https://'.$_SERVER['SERVER_NAME'].'/bots/allcardshere/img/cards/obi.jpeg')
                    ->setKeyboard($kbrd)
            );
        })
        
        ->onText("/okey|окей/ius", function ($event) use ($bot, $botSender, $log, $storage) {
            $log->info('onClear' . $event->getMessage()->getText());
            $kbrd = require_once(__DIR__.'/../keyboards/mainMenu.php');
            $bot->getClient()->sendMessage(
                (new \Viber\Api\Message\Picture())
                    ->setSender($botSender)
                    ->setReceiver($event->getSender()->getId())
                    ->setText('Дайте отсканировать эту карту кассиру')
                    ->setMedia('https://'.$_SERVER['SERVER_NAME'].'/bots/allcardshere/img/cards/okey.jpeg')
                    ->setKeyboard($kbrd)
            );
        })

        ->onText("/polushka|полушка/ius", function ($event) use ($bot, $botSender, $log, $storage) {
            $log->info('onClear' . $event->getMessage()->getText());
            $kbrd = require_once(__DIR__.'/../keyboards/mainMenu.php');
            $bot->getClient()->sendMessage(
                (new \Viber\Api\Message\Picture())
                    ->setSender($botSender)
                    ->setReceiver($event->getSender()->getId())
                    ->setText('Дайте отсканировать эту карту кассиру')
                    ->setMedia('https://'.$_SERVER['SERVER_NAME'].'/bots/allcardshere/img/cards/polushka.jpeg')
                    ->setKeyboard($kbrd)
            );
        })
        
        ->onText("/spar|спар/ius", function ($event) use ($bot, $botSender, $log, $storage) {
            $log->info('onClear' . $event->getMessage()->getText());
            $kbrd = require_once(__DIR__.'/../keyboards/mainMenu.php');
            $bot->getClient()->sendMessage(
                (new \Viber\Api\Message\Picture())
                    ->setSender($botSender)
                    ->setReceiver($event->getSender()->getId())
                    ->setText('Дайте отсканировать эту карту кассиру')
                    ->setMedia('https://'.$_SERVER['SERVER_NAME'].'/bots/allcardshere/img/cards/spar.jpeg')
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
            $str = "Похоже такой карты нет. Записали, постараемся добавить. \n Не смогла помочь - давайте я вам анекдот расскажу: \n";
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
