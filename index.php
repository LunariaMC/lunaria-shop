<?php
include("RabbitConnection.php");
use Shop\RabbitConnection;
use Twig\Environment;
use Twig\Loader\ArrayLoader;
use Twig\Loader\FilesystemLoader;

$conn = new RabbitConnection("127.0.0.1", "5672", "guest", "guest");
//$conn->sendMessage("Papipomme", 2);
$conn->close();

$request = $_SERVER['REQUEST_URI'];

$loader = new FilesystemLoader(__DIR__ . '/templates/');
$twig = new Environment($loader, [
    'cache' => __DIR__ . '/compilation_cache/',
]);

switch ($request) {
    default:
        echo $twig->render(__DIR__ . "/templates/index.twig");
        break;
}