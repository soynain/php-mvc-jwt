<?php
class Router
{
    private static $controllerName;
    private static $controlleMethodName;

    public static function serveEndpoint($method = "GET", $route = "/")
    {
        $currentMethod = $method;
        $currentUrl = $route;

        if ($currentMethod === $method) {
            $urlDefragmentation = explode("/", trim($currentUrl, " "));
            Router::$controllerName = !empty(ucwords($urlDefragmentation[1])) ? ucwords($urlDefragmentation[1])."Controller" : "AccessController";
            Router::$controlleMethodName = !empty($urlDefragmentation[2]) ? $urlDefragmentation[2] : "exception";
            //echo Router::$controlleMethodName." ".Router::$controllerName;
            require_once __DIR__ . "/Controllers/" . Router::$controllerName . ".php";
            
            DbConnection::init();
            $controllerInstance=new Router::$controllerName(DbConnection::getConnection());
            $authMiddleware=new AuthMiddlewareJwt($controllerInstance,Router::$controlleMethodName);
        }else{
            $response=new ResponseDto(500,"NOT FOUND");
        }
    }
}
