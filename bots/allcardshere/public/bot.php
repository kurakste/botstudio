<?php
require_once("../../../vendor/autoload.php");

use Viber\Bot;
use Viber\Api\Sender;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use app\allcardshere\services\Storage;
use app\allcardshere\services\Parser;
use skills\humor\Anekdot;

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
        ->onText('|cardlist|s', function ($event) use ($bot, $botSender, $log, $storage) {
            $kbrd = require_once(__DIR__.'/../keyboards/mainMenu.php');
            $log->info('cardlist method:');
            $parser = new Parser;
            $str = "У нас есть следующие карты: ".$parser->getAllCardsNameAsString().".";
            $bot->getClient()->sendMessage(
                (new \Viber\Api\Message\Text())
                    ->setSender($botSender)
                    ->setReceiver($event->getSender()->getId())
                    ->setText($str)
                    ->setKeyboard($kbrd)
            );
        })
        ->onText('|help|s', function ($event) use ($bot, $botSender, $log, $storage) {
            $kbrd = require_once(__DIR__.'/../keyboards/mainMenu.php');
            $log->info('menu method:');
            $str = require_once(__DIR__.'/../messages/help.php');;
            $bot->getClient()->sendMessage(
                (new \Viber\Api\Message\Text())
                    ->setSender($botSender)
                    ->setReceiver($event->getSender()->getId())
                    ->setText($str)
                    ->setKeyboard($kbrd)
            );
        })
        ->onText('|donate|s', function ($event) use ($bot, $botSender, $log, $storage) {
            $kbrd = require_once(__DIR__.'/../keyboards/mainMenu.php');
            $log->info('donate method:');
            $parser = new Parser;
            $str = require_once(__DIR__.'/../messages/donate.php');;
            $bot->getClient()->sendMessage(
                (new \Viber\Api\Message\Text())
                    ->setSender($botSender)
                    ->setReceiver($event->getSender()->getId())
                    ->setText($str)
                    ->setKeyboard($kbrd)
            );
        })

        ->onText('|.*|s', function ($event) use ($bot, $botSender, $log, $storage) {
            $parser = new Parser;
            $card = $parser->parse($event->getMessage()->getText());
            $kbrd = require_once(__DIR__.'/../keyboards/mainMenu.php');

            if ($card) {
            // If we parse frase & get triger we are here
                if ($card['cardavailable']) {
                    $image = 'https://'.$_SERVER['SERVER_NAME']
                        .'/bots/allcardshere/img/cards/'
                        .$card['card'];
                    $bot->getClient()->sendMessage(
                        (new \Viber\Api\Message\Picture())
                            ->setSender($botSender)
                            ->setReceiver($event->getSender()->getId())
                            ->setText($card['message'])
                            ->setMedia($image)
                            ->setKeyboard($kbrd)
                    );
                } else {
                    $bot->getClient()->sendMessage(
                        (new \Viber\Api\Message\Text())
                            ->setSender($botSender)
                            ->setReceiver($event->getSender()->getId())
                            ->setText($card['message'])
                            ->setKeyboard($kbrd)
                    );
                }
            } else {
                // We parse frase but there are no triggers.
                $storage->logMessageToDb(
                    "allcardshere",
                    $event->getMessage()->getText(),
                    $event->getSender()->getId(),
                    "allcardshere",
                    $event->getMessage()->getTrackingData()
                );

                $joke = Anekdot::getRandomAnekdot();
                $str = "Похоже такой карты нет. Записали, постараемся добавить. \n Не смогла помочь - давайте я вам анекдот расскажу: \n";
                $str = $str.$joke;
                $log->info('onText ' . $event->getMessage()->getText());

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
            }

        })
        ->run();
} catch (Exception $e) {
    $log->warning('Exception: ' . $e->getMessage());
    if ($bot) {
        $log->warning('Actual sign: ' . $bot->getSignHeaderValue());
        $log->warning('Actual body: ' . $bot->getInputBody());
    }
}
