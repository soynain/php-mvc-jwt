<?php
class AuthMiddlewareJwt
{
    protected $objectInstance;
    protected $methodName;
    protected $jwtHeader;

    public function __construct($obj, $mtd)
    {
        $this->objectInstance = $obj;
        $this->methodName = $mtd;
        $this->checkAuth();
    }

    public function checkAuth()
    {
        $this->jwtHeader = array_key_exists("bearer-token", getallheaders()) ? trim(getallheaders()["bearer-token"]) : null;
        if ($this->objectInstance instanceof LoginController) {
            if ($this->jwtHeader !== null && !empty($this->jwtHeader)) {
                $decodedToken = JwtDecoderComponent::decode($this->jwtHeader);
                if ($decodedToken !== null) { //we can extend the functionality returns by getting the instance of the resultant exception in case of jwt errors
                    $response = new ResponseDto(300, "ALREADY LOGGED");
                    $response->responseSend();
                } else {
                    $response = new ResponseDto(0, "");
                    $response->unauthorizedSend();
                    exit;
                }
            } else {
                $this->next();
            }
        } else {
            if ($this->jwtHeader !== null && !empty($this->jwtHeader)) {
                $this->next();
            } else {
                $response = new ResponseDto(0, "");
                $response->unauthorizedSend();
                exit;
            }
        }
    }

    public function next()
    {
        $methodInstance = $this->methodName;
        $this->objectInstance->$methodInstance();
    }
}
