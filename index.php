<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/Loader.php';
use Shop\Loader;

$twig = Loader::init();

session_start();
if(!isset($_POST['username']) && !isset($_SESSION['username']) && $_SESSION['username'] == null) {
    echo $twig->render('login.twig', [
        "title" => "Lunaria - Boutique"
    ]);
} else {
    if(isset($_SESSION['username'])) $_SESSION['username'] = htmlspecialchars($_POST['username']);

    echo $twig->render('index.twig', [
        "title" => "Lunaria - Boutique",
        "username" => htmlspecialchars($_SESSION['username'])
    ]);
}