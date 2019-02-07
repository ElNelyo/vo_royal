<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../object/personne.php';

// instantiate database and famille object
$database = new Database();
$db = $database->getConnection();

// initialize object
$people = new Personne($db);

// query familles
$stmt = $people->read();
$num = $stmt->rowCount();


// check if more than 0 record found
if($num>0){

    // familles array
    $people_arr=array();
    $people_arr["records"]=array();

    // retrieve our table contents
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
        $people_obj=array(
            "id" => $id,
            "nom" => $nom,
            'prenom' => $prenom,
            'famille' => $famille
        );

        array_push($people_arr["records"], $people_obj);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show familles data in json format
    echo json_encode($people_arr);
}

else{

    // set response code - 404 Not found
    http_response_code(404);

    // tell the user no familles found
    echo json_encode(
        array("message" => "No personne found.")
    );
}
