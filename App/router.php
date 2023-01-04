<?php
class Router
{
    private static $controllerName;
    private static $controlleMethodName;
    /* Yeah, this shouldnt be here but works for now*/
    private static $routesArray=[
        "/login/auth"=>"POST",
        "/productos/get"=>"GET",
        "/productos/saveprod"=>"POST",
        "/productos/update"=>"POST",
        "/productos/delete"=>"POST"
    ];

    private static function validateRouteExistence($route){
        return array_key_exists($route,Router::$routesArray)?true:false;
    }

    private static function validateRequestMethod($route,$sentMethod){
        return Router::$routesArray[$route]===$sentMethod?true:false;
    }

    /*I can optimize the method since Im using a route method
    to validate route and method existence in a class where
    that's not its responsability */
    public static function serveEndpoint($method = "GET", $route = "/")
    {
        $currentMethod = $method;
        $currentUrl = $route;
        if(Router::validateRouteExistence($currentUrl) && Router::validateRequestMethod($currentUrl,$currentMethod)){
            $urlDefragmentation = explode("/", trim($currentUrl, " "));
            Router::$controllerName = !empty(ucwords($urlDefragmentation[1])) ? ucwords($urlDefragmentation[1])."Controller" : "AccessController";
            Router::$controlleMethodName = !empty($urlDefragmentation[2]) ? $urlDefragmentation[2] : "exception";
            require_once __DIR__ . "/Controllers/" . Router::$controllerName . ".php";
            
            DbConnection::init();
            $controllerInstance=new Router::$controllerName(DbConnection::getConnection());
            $authMiddleware=new AuthMiddlewareJwt($controllerInstance,Router::$controlleMethodName);
        }else{
            $response=new ResponseDto(400,"BAD REQUEST");
            $response->responseSend();
        }
    }
}
