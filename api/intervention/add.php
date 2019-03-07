<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../object/intervention.php';

// instantiate database and famille object
$database = new Database();
$db = $database->getConnection();

// initialize object
$intervention = new Intervention ($db);
if (isset($_GET)) {
    if ( (isset($_GET['titre']) && $_GET['titre'] != "" )) {
        $intervention->titre = $_GET['titre'];
    }


    if ( (isset($_GET['priorite']) && $_GET['priorite'] != "" )) {

        $intervention->priorite = $_GET['priorite'];
    }

    if ( (isset($_GET['detail']) && $_GET['detail'] != "" )) {

        $intervention->detail = $_GET['detail'];
    }

    if ( (isset($_GET['personne']) && $_GET['personne'] != "" )) {


        $intervention->personne = $_GET['personne'];
    }
// set product property values

}
// query familles
$stmt = $intervention->add();
if($stmt){
    // set response code - 404 Not found
    http_response_code(200);

    // tell the user no familles found
    echo json_encode(
        array("message" => "Intervention added.")
    );
}
else{

    // set response code - 404 Not found
    http_response_code(404);

    // tell the user no familles found
    echo json_encode(
        array("message" => "No intervention found.")
    );
}
