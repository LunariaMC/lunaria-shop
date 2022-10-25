<?php
include('RabbitConnection.php');
include('Loader.php');

use Shop\Loader;
use Shop\RabbitConnection;

$twig = Loader::init();

//$conn = new RabbitConnection("127.0.0.1", "5672", "guest", "guest");
//$conn->sendMessage("Papipomme", 2);
//$conn->close();

session_start();
if(htmlspecialchars($_SESSION['username']) == null) {
    die("Une erreur est survenue lors du chargement de la page, merci de contacter un admin sur le discord.\nhttps://discord.lunaria-mc.net");
}

$code = isset($_POST['code']) ? preg_replace('/[^a-zA-Z0-9]+/', '', $_POST['code']) : '';
if(empty($code) ) {
    $message = 'Vous devez saisir un code';
}
else {
    $dedipass = file_get_contents('http://api.dedipass.com/v1/pay/?public_key=631f4893d642b6b2dabf12dd15092d72&private_key=cdf2285edbf52dac94c967207c5c2da1e0e9ccc6&code=' . $code);
    $dedipass = json_decode($dedipass);
    if($dedipass->status == 'success') {
        $virtual_currency = $dedipass->virtual_currency;
        $message = 'Le code est valide et vous êtes crédité de ' . $virtual_currency . 'Planètes';

        //$conn = new RabbitConnection("127.0.0.1", "5672", "guest", "guest");
        //$conn->sendMessage("Papipomme", $virtual_currency);
        //$conn->close();
        session_destroy();
        session_unset();
    }
    else {
        // Le code est invalide
        $message = 'Le code '.$code.' est invalide';
    }
}

echo $twig->render('done.twig', [
    "title" => "Lunaria - Boutique",
    "message" => $message
]);