<?php
class LoginController extends Orm
{

    protected $id;
    protected $table;
    protected $conn;
    public function __construct(PDO $conn)
    {
        parent::__construct('idCredencial', 'usuariocredenciales', $conn);
    }

    private function contrasena($contrasena, $hash)
    {
        return password_verify($contrasena, $hash) ? true : false;
    }

    public function auth()
    {

        $contentPost=json_decode(file_get_contents("php://input"),true);

        $credenciales = $this->connection->prepare("SELECT * FROM {$this->table} WHERE usuario = :usuario");
        $credenciales->bindValue("usuario",$contentPost["usertxt"]);
        $credenciales->execute();
        $fetchCredenciales = $credenciales->fetch();//if user not found, returns bool false
       // var_dump($fetchCredenciales);
        if ($fetchCredenciales!==false) {
            $payload = [
                'iss' => 'http://localhost',
                'aud' => 'http://localhost',
                'iat' => 1356999524,
                'nbf' => 1357000000,
                'id' => $fetchCredenciales["fkUsuarioDatos"],
                'user' => $fetchCredenciales["usuario"]
            ];
            $jwtToken = $this->contrasena($contentPost["passtxt"], $fetchCredenciales["contrasena"]) ? JwtEncoderClass::encodeJwt($payload, KEY_ENC) : null;
            if($jwtToken!==null){
                $response=new ResponseDto(200,json_encode(["Bearer-token"=>$jwtToken]));
            }else{
                $response=new ResponseDto(401,"BAD CREDENTIALS");
            }
        }else{
            $response=new ResponseDto(404,"USER NOT FOUND");
        }
        $response->responseSend();
    }
}
