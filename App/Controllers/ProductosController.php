<?php
class ProductosController extends Orm{
    public function __construct(PDO $conn)
    {
        parent::__construct('idProducto','productos',$conn);
    }

    public function get(){
        $productsList=$this->getAll();
        $response=new ResponseDto(200,$productsList);
        $response->responseSend();
    }
}
?>