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
        echo json_encode(["status"=>$this->responseStatus,"body"=>$this->body]);
    }
}
?>