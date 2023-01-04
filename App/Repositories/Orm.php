<?php
class Orm{
    protected $id;
    protected $table;
    protected $connection;

    public function __construct($id,$table,PDO $connection)
    {
        $this->id=$id;
        $this->table=$table;
        $this->connection=$connection;
    }

    public function getAll(){
        $stmExec="SELECT * FROM {$this->table}";
        $stm=$this->connection->prepare($stmExec);
        $stm->execute();
        $queryDone=$stm->fetchAll();
        return $queryDone;
    }

    public function getById($id){
        $stmExec="SELECT * FROM {$this->table} where {$this->id}={$id}";
        $stm=$this->connection->prepare($stmExec);
        $stm->execute();
        $queryDone=$stm->fetchAll();
        return $queryDone;
    }

    public function updateById($id,$arrData){
        $stmExec="UPDATE {$this->table} SET ";
        foreach($arrData as $keys=>$values){
            $stmExec.="{$keys}=:{$keys}".",";
        }
        $stmExec=trim($stmExec,",");
        $stmExec.=" WHERE {$this->id}={$id}";
        $stm=$this->connection->prepare($stmExec);
        foreach($arrData as $keys=>$values){
            $stm->bindValue($keys,$values);
        }
        $stm->execute();
    }

    public function deleteById($id){
        $stmExec="DELETE FROM {$this->table} where {$this->id}={$id}";
        $stm=$this->connection->prepare($stmExec);
        $stm->execute();
    }

    public function save($arrData){
        $stmExec="INSERT INTO {$this->table} VALUES (null,";
        foreach($arrData as $keys=>$values){
            $stmExec.=":{$keys}".",";
        }
        $stmExec=trim($stmExec,",");
        $stmExec.=")";
        //var_dump($stmExec);
        $stm=$this->connection->prepare($stmExec);
        foreach ($arrData as $key => $value) {
            $stm->bindValue($key,$value);
        }
        $stm->execute();
    }
}
?>