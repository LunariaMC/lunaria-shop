<?php
include("RabbitConnection.php");
use Shop\RabbitConnection;

$conn = new RabbitConnection("127.0.0.1", "5672", "guest", "guest");
$conn->sendMessage("CrypenterTV", 2);
$conn->close();