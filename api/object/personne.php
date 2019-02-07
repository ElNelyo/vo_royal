<?php
class Personne{

    // database connection and table name
    private $conn;
    private $table_name = "personne";

    // object properties
    public $id;
    public $nom;
    public $famille;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read familles
    function read(){

        // select all query
        $query = "SELECT p.id, p.nom , p.prenom, famille.nom as famille FROM personne p left join famille on p.famille = famille.id ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();


        return $stmt;

    }
}
