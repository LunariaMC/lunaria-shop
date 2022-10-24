<?php

namespace Shop;
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use \PhpAmqpLib\Channel\AMQPChannel;

class RabbitConnection
{
    /**
     * @var AMQPStreamConnection
     */
    private $conn;
    /**
     * @var AMQPChannel
     */
    private $channel;

    public function __construct($host, $port, $user, $password) {
        $this->conn = new AMQPStreamConnection($host, $port, $user, $password);
        if(!$this->conn->isConnected()) die();

        $this->channel = $this->conn->channel();
    }

    public function sendMessage($player, $amount) {
        $message = new AMQPMessage('{"player":"' . htmlspecialchars($player) . '","value":"' . htmlspecialchars($amount) . '"}');
        $this->channel->basic_publish($message, "web:bungee:shopAction", "shopAction");
    }

    public function close() {
        $this->channel->close();
        $this->conn->close();
    }
}