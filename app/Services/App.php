<?php

namespace App\Services;

class App
{
    //функция-которая запускает все остальные функции
    public static function start()
    {
        self::libs();
        self::db();
    }

    public static function libs()
    {
        $config = require_once "config/app.php";
        foreach ($config["libs"] as $lib) {
            //по сути тут мы указываем на "rb" из config/app.php
            require_once "libs/" . $lib . ".php";
        }
    }

    public static function db()
    {
        $config = require_once "config/db.php";

        if ($config["enable"]) {
            //класс R для редбин пхп inter искал в сервайсе, а надо глобально поставим перед R \
            \R::setup( 'mysql:host=' . $config["host"] . ';port=' . $config["port"] . ';dbname=' . $config["db"] . '',
                $config["username"], $config["password"] ); //for both mysql or mariaDB

            if (!\R::testConnection()) {
                die('Error database connect');
            }
        }
    }
}