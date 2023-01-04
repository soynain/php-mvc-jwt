<?php
class Router
{
    private static $controllerName;
    private static $controlleMethodName;

    public static function serveEndpoint($method = "GET", $route = "/")
    {
        $currentMethod = $_SERVER["REQUEST_METHOD"];
        $currentUrl = $_SERVER["REQUEST_URI"];

        if ($currentMethod === $method) {
            $urlDefragmentation = explode("/", trim($currentUrl, " "));
            Router::$controllerName = !empty(ucwords($urlDefragmentation[1])) ? ucwords($urlDefragmentation[1]) : "AccessController";
            Router::$controlleMethodName = !empty($urlDefragmentation[2]) ? $urlDefragmentation[2] : "exception";

            require_once __DIR__ . "/Controllers/" . Router::$controllerName . ".php";

            $controllerInstance=new Router::$controllerName();
            
        }else{
            $response=new ResponseDto(500,"NOT FOUND");
        }
    }
}
