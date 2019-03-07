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

$intervention = new Intervention($db);
$stmt =$intervention->delete($_GET['id']);

if($stmt){
    // set response code - 404 Not found
    http_response_code(200);

    // tell the user no familles found
    echo json_encode(
        array("message" => "Intervention deleted.")
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
