<?php

namespace app\botseller\services;

/**
 * This class will storge messages in database.
 * The structure of db record is: 
 * bot_id, // id of bot 
 * senderId, who send message
 * destMessageId, 
 * context
 */
class Storage {

    protected $dsn;
    protected $dbusername; 
    protected $dbpassword;
    protected $pdo;

    public function __construct($dsn, $dbusername, $dbpassword) {
        $this->dsn = $dsn;
        $this->dbusername = $dbusername;
        $this->dbpassword = $dbpassword;
        $opt = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        ];

        $this->pdo = new \PDO(
            $dsn,
            $this->dbusername,
            $this->dbpassword,
            $opt
        );
        var_dump($this->pdo);
    }

    public function logMessageToDb($botId, $message, $senderId, $destMessageId, $context) {
        $sql = "INSERT INTO messages (botId, message, senderId, destMessageId, context, time) VALUES "
            ."( ?, ?, ?, ?, ?, ?);";
        $params = [ $botId, $message, $senderId, $destMessageId, $context, date('Y-m-d H:i:s') ];
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
    }
}