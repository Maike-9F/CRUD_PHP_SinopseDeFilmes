<?php

class Banco{

    private $conn;
    private $user = "root";
    private $pass = "";
    private $local = "localhost";
    private $database = "filmes_sinopse";

   function __construct()
   {
       try{
           $this->conn = new PDO("mysql:host=$this->local;dbname=$this->database;charset=utf8",$this->user,$this->pass);
       } catch(PDOException $e){
           die("<p style='color:red;'>$e</p>");
       }
   }

    //CRUD

    //CREATE
    public function insert($sql, array $bind)
    {
        $dados = $this->conn->prepare($sql);

        foreach($bind as $key => $value){
            $dados->bindValue($key, $value);
        }
        $result = $dados->execute();

        if($result){
            return true;
        } else {
            return false;
        }

    }

    //READ
    public function select($sql, array $bind)
    {
        $conexao = $this->conn->prepare($sql);
        foreach($bind as $key=>$value){
            $conexao->bindValue($key, $value);
        }
 
        $conexao->execute();
        return $conexao;
        
    }

    //UPDATE
    public function update($sql, array $bind)
    {
        $conexao = $this->conn->prepare($sql);
        foreach($bind as $key=>$value){
            $conexao->bindValue($key, $value);
        }

        if($conexao->execute()){
            return true;
        } else{
            return false;
        }
    }

    //DELETE
    public function delete($sql, array $bind)
    {
        $conexao = $this->conn->prepare($sql);
        foreach($bind as $key=>$value){
            $conexao->bindValue($key, $value);
        }

        if($conexao->execute()){
            return true;
        } else{
            return false;
        }
    }

    public function desconectar(){
        $this->conn = null;
    }
}