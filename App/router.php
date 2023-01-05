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
        "/productos/updateprod"=>"POST",
        "/productos/deleteprod"=>"POST"
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
        $urlDefragmentation = explode("/", trim($currentUrl, " "));
        /*This is for allowing have an url with more paramethers, dirty solution i think, but its for studying, not for a job
        to have cleaner solution, i must change the router implementation almost to start with,
        by having two methods: GET and POST, each one with the same parameters
        as serveEndPoint() and looking for the route's existence on a route's array list
        then encapsulate the lines of code under the if statement in a method, so
        we dont use an if anymore and with an exception, redirect to BAD REQUEST*/
        $verifyPrincipalUrl="/".join("/",[$urlDefragmentation[1],$urlDefragmentation[2]]);
        if(Router::validateRouteExistence($verifyPrincipalUrl) && Router::validateRequestMethod($verifyPrincipalUrl,$currentMethod)){
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
