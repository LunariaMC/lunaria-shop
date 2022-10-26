<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/Loader.php';
use Shop\Loader;

$twig = Loader::init();

if(isset($_GET['username'])) {
    setcookie("username", htmlspecialchars($_GET['username']), time()+60*60*24*30);
    echo $twig->render('index.twig', [
        "title" => "Lunaria - Boutique",
        "username" => htmlspecialchars($_GET['username'])
    ]);
} else {
    echo $twig->render('login.twig', [
        "title" => "Lunaria - Boutique"
    ]);
}