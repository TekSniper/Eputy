<?php

class DatabaseConnection{
    private $connection;
    function __construct(){
        $this->connection = new PDO('pgsql:host=localhost;port=5432;dbname=eputy_base','postgres','secret');
    }

    function GetConnectionString(){
        try
        {
            $this->connection;
        }
        catch(PDOException $ex){
            die("Erreur de connexion : " . $ex->getMessage());
        }
        return $this->connection;
    }
}