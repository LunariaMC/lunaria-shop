<?php
namespace Shop;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
abstract class Loader {

    private static $twig;
    private static $loader;

    public static function init() {
        self::$loader = new FilesystemLoader(__DIR__ . "/templates");
        self::$twig = new Environment(self::$loader, [
            'cache' => false
        ]);
        return self::$twig;
    }

    /**
     * @return mixed
     */
    public static function getLoader()
    {
        return self::$loader;
    }
    /**
     * @return mixed
     */
    public static function getTwig()
    {
        return self::$twig;
    }
}