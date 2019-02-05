<?php
class Famille{

    // database connection and table name
    private $conn;
    private $table_name = "famille";

    // object properties
    public $id;
    public $nom;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read familles
    function read(){

        // select all query
        $query = "SELECT id, name FROM famille ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();


        return $stmt;

    }
}