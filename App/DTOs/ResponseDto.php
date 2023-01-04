<?php
class ResponseDto{
    protected $responseStatus;
    protected $body;

    public function __construct($responseStatus,$body)
    {
        $this->responseStatus=$responseStatus;
        $this->body=$body;
    }


    public function responseSend(){
        http_response_code($this->responseStatus);
        echo json_encode(["status"=>$this->responseStatus,"body"=>$this->body]);
    }

    public function unauthorizedSend(){
        http_response_code(401);
        echo json_encode(["status"=>401,"body"=>"UNAUTHORIZED"]);
    }
}
?>