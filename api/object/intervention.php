<?php
class Intervention{

    // database connection and table name
    private $conn;
    private $table_name = "intervention";

    // object properties
    public $id;
    public $titre;
    public $detail;
    public $priorite;
    public $personne;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read familles
    function read(){

        // select all query
        $query = "SELECT i.id, i.titre, i.detail, i.priorite, personne.nom as personne FROM intervention i left join personne on i.personne= personne.id ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();


        return $stmt;

    }
}
