<?php 
class DbConnection{
    private static $dsn;
    private static $connection;
    private static $username="root";
    private static $password="211772809";

    public function __construct()
    {
        $this->init();
    }

    public static function init(){
        $opt=[
            PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION
        ];
        try {
            DBConnection::$dsn="mysql:host=localhost;port=3306;dbname=productodphpdb";
            DbConnection::$connection=new PDO(
                DbConnection::$dsn,
                DbConnection::$username,
                DbConnection::$password,
                $opt
            );
        } catch (PDOException $th) {
            http_response_code(501);
            echo json_encode(["error"=>"server error"]);
        }
    }


    public static function closeConn(){
        DbConnection::$connection=null;
    }
}
?>