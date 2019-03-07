<?php

class Intervention
{

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
    public function __construct($db)
    {
        $this->conn = $db;
    }

    function add()
    {

        $query = "INSERT INTO intervention (titre,detail,priorite,personne) VALUES ('$this->priorite','$this->detail','$this->priorite','$this->personne')";
        var_dump($query);
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();


        return $stmt;
    }

    function get($id)
    {

        // select all query
        $query = "SELECT i.id, i.titre, i.detail, i.priorite, personne.id AS personne FROM intervention i LEFT JOIN personne ON i.personne= personne.id WHERE i.id=" . $id . " ORDER BY i.id ";
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();


        return $stmt;

    }

    // read familles
    function read()
    {

        // select all query
        $query = "SELECT i.id, i.titre, i.detail, i.priorite, personne.nom AS personne FROM intervention i LEFT JOIN personne ON i.personne= personne.id ORDER BY i.id ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();


        return $stmt;

    }

// update the product
    function update()
    {

        // update query
        $query = "UPDATE
                " . $this->table_name . "
            SET
                titre = :titre,
                priorite = :priorite,
                detail = :detail,
                personne = :personne
            WHERE
                id = :id";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->titre = htmlspecialchars(strip_tags($this->titre));
        $this->priorite = htmlspecialchars(strip_tags($this->priorite));
        $this->detail = htmlspecialchars(strip_tags($this->detail));
        $this->personne = htmlspecialchars(strip_tags($this->personne));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind new values
        $stmt->bindParam(':titre', $this->titre);
        $stmt->bindParam(':priorite', $this->priorite);
        $stmt->bindParam(':detail', $this->detail);
        $stmt->bindParam(':personne', $this->personne);
        $stmt->bindParam(':id', $this->id);

        // execute the query
        if ($stmt->execute()) {
            return true;
        }


    }
}