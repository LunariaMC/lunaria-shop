<?php
include('RabbitConnection.php');
include('Loader.php');

use Shop\Loader;
use Shop\RabbitConnection;

$twig = Loader::init();

session_start();
if(!isset($_COOKIE['username'])) {
    die("Une erreur est survenue lors du chargement de la page, merci de contacter un admin sur le discord.\nhttps://discord.lunaria-mc.net");
}
$virtual_currency = 0;
$code = isset($_POST['code']) ? preg_replace('/[^a-zA-Z0-9]+/', '', $_POST['code']) : '';
if(empty($code) ) {
    $message = 0;
}
else {
    $dedipass = file_get_contents('http://api.dedipass.com/v1/pay/?public_key=631f4893d642b6b2dabf12dd15092d72&private_key=cdf2285edbf52dac94c967207c5c2da1e0e9ccc6&code=' . $code);
    $dedipass = json_decode($dedipass);
    if($dedipass->status == 'success') {
        $virtual_currency = $dedipass->virtual_currency;
        $message = 1;

        $conn = new RabbitConnection("127.0.0.1", "5672", "guest", "guest");
        $conn->sendMessage(htmlspecialchars($_COOKIE['username']), $virtual_currency);
        $conn->close();
        setcookie("username", htmlspecialchars($_COOKIE['username']), 1);
    }
    else {
        // Le code est invalide
        $message = 2;
    }
}

echo $twig->render('done.twig', [
    "title" => "Lunaria - Boutique",
    "message" => $message,
    "currency" => $virtual_currency
]);