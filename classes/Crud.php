<?php
include_once('conexao/conexao.php');

$db = new Database();

class Crud{
    private $conn;
    private $table_name = "carros";

    public function __construct($db){
        $this->conn = $db;
    }

    //funcao parar (C)riar meu registros
    public function create($postValues){
        $modelo = $postValues['modelo'];
        $marca = $postValues['marca'];
        $placa = $postValues['placa'];
        $cor = $postValues['cor'];
        $ano = $postValues['ano'];

        $query = "INSERT ". $this->table_name . " (modelo, marca, placa, cor, ano) VALUES (?,?,?,?,?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$modelo);
        $stmt->bindParam(2,$marca);
        $stmt->bindParam(3,$placa);
        $stmt->bindParam(4,$cor);
        $stmt->bindParam(5,$ano);
                    

        $rows = $this->read();
        if($stmt->execute()){
            print "<script>alert('Cadastro Ok!')</script>";
            print "<script> location.href='?action=read'; </script>";
            return true;
        }else{
            return false;
        }
    }

    //funcao para Ler os registros
    public function read(){
        $query = "SELECT * FROM ". $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    //funcao atualizar registros
    public function update($postValues){
        $id = $postValues['id'];
        $modelo = $postValues['modelo'];
        $marca = $postValues['marca'];
        $placa = $postValues['placa'];
        $cor = $postValues['cor'];
        $ano = $postValues['ano'];

        if(empty($id) || empty($modelo) || empty($marca) || empty($placa) || empty($cor) || empty($ano)){
            return false;
        }

        $query = "UPDATE ". $this->table_name . " SET modelo = ?, marca = ?, placa = ?, cor = ?, ano = ?  WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$modelo);
        $stmt->bindParam(2,$marca);
        $stmt->bindParam(3,$placa);
        $stmt->bindParam(4,$cor);
        $stmt->bindParam(5,$ano);
        $stmt->bindParam(6, $id);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
      
    }
      //funcao para pegar os registros do banco e inserir no formulario
    public function readOne($id){
        $query = "SELECT * FROM ". $this->table_name . " WHERE id = ?";
        $stmt =$this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}


?>