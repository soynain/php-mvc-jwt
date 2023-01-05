<?php
class ProductosController extends Orm
{
    public function __construct(PDO $conn)
    {
        parent::__construct('idProducto', 'productos', $conn);
    }

    public function get()
    {
        $productsList = json_encode($this->getAll());
        $response = new ResponseDto(200, $productsList);
        $response->responseSend();
    }

    public function saveprod()
    {
        $contentPost = json_decode(file_get_contents("php://input"), true);
        $arrDto = [
            "nombreProducto" => $contentPost["nombretxt"],
            "descripcionProducto" => $contentPost["descripciontxt"],
            "precioProducto" => $contentPost["preciotxt"],
            "fabricante" => $contentPost["fabricantetxt"]
        ];

        try {
            $this->save($arrDto);
            $response = new ResponseDto(200, "SUCCESS");
            $response->responseSend();
        } catch (\Throwable $th) {
            $response = new ResponseDto(500, $th);
            $response->responseSend();
        }
    }

    public function updateprod(){
        $urlPathParam=array_key_exists(3,explode("/",URL))?explode("/",URL)[3]:null;
        //var_dump($urlPathParam);
        if($urlPathParam!==null){
            $contentPost = json_decode(file_get_contents("php://input"), true);
            $this->updateById($urlPathParam,[
                "nombreProducto" => $contentPost["nombretxt"],
                "descripcionProducto" => $contentPost["descripciontxt"],
                "precioProducto" => $contentPost["preciotxt"],
                "fabricante" => $contentPost["fabricantetxt"]
            ]);
            $response=new ResponseDto(200,"SUCCESS");
            $response->responseSend();
        }else{
            $response=new ResponseDto(400,"BAD REQUEST");
            $response->responseSend();
        }
    }

    public function deleteprod(){
        $urlPathParam=array_key_exists(3,explode("/",URL))?explode("/",URL)[3]:null;
        //var_dump($urlPathParam);
        if($urlPathParam!==null){
            $this->deleteById($urlPathParam);
            $response=new ResponseDto(200,"SUCCESS");
            $response->responseSend();
        }else{
            $response=new ResponseDto(400,"BAD REQUEST");
            $response->responseSend();
        }
    }

}
