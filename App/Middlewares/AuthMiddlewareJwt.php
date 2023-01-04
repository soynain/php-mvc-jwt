<?php
class AuthMiddlewareJwt{
    protected $objectInstance;
    protected $methodName;
    protected $jwtHeader;

    public function __construct($obj,$mtd,$jwtHeader)
    {
        $this->objectInstance=$obj;
        $this->methodName=$mtd;
        $this->jwtHeader=$jwtHeader;
    }

    public function checkAuth(){

    }

    public function next(){

    }
}
?>