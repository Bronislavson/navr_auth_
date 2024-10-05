<?php


namespace App\Services;

class Router
{
    public static $list = [];

    /**
     * Метод рег. роут для обычной страницы
     * @param $uri
     * @param $page_name
    **/
    public static function page($uri, $page_name)
    {
        self::$list[] = [
            "uri" => $uri,
            "page" => $page_name
        ];
    }
    public static function post($uri, $class, $method, $formdata = false)
    {
        self::$list[] = [
            "uri" => $uri,
            "class" => $class,
            "method" => $method,
            "post" => true,
            "formdata" => $formdata
        ];
    }

    public static function enable()
    {
        /* $query = isset($_GET['path']) ? $_GET['path'] : 'home'; */
        $query = $_GET['path'] ?? null;
        
        foreach (self::$list as $route) {
            if ($route['uri'] === '/' . $query) {
                if (array_key_exists("post", $route) && $route["post"] === true && $_SERVER["REQUEST_METHOD"] === "POST") {
                /* if ($route["post"] === true && $_SERVER["REQUEST_METHOD"] === "POST") { */
                    $action = new $route["class"];
                    $method = $route["method"];

                    if ($route["formdata"]) {
                        $action->$method($_POST);
                    } else {
                        $action->$method();
                    }
                    die(); // Завершает выполнение скрипта
                } else {
                    require_once "views/pages/" . $route['page'] . ".php";
                    // Если обратились к несуществующей странице
                    //Проверяем и не нашли совпадение, то уничтожаем исполнение кода
                    die(); // Завершает выполнение скрипта
                }
            }
        }  
        self::error(error:404);
    }
    public static function error($error)
    {
        require_once "views/errors/" . $error . ".php";
    }

    public static function redirect($uri)
    {
        header('Location:' . $uri);
    }
}    