<?php
class ProductosController extends Orm
{
    public function __construct(PDO $conn)
    {
        parent::__construct('idProducto', 'productos', $conn);
    }

    public function get()
    {
        $productsList = $this->getAll();
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

}
