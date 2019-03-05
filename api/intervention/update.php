<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/database.php';
include_once '../object/intervention.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare product object
$intervention = new Intervention($db);

// get id of product to be edited
$data = json_decode(file_get_contents("php://input"));
if (isset($_GET)) {
    $intervention->id = $_GET['id'];
    if (isset($_GET['titre'])) {
        $intervention->titre = $_GET['titre'];
    }
    if (isset($_GET['priorite'])) {
        $intervention->priorite = $_GET['priorite'];
    }
    if (isset($_GET['detail'])) {
        $intervention->detail = $_GET['detail'];
    }
    if (isset($_GET['personne'])) {
        $intervention->personne = $_GET['personne'];
    }
// set product property values

}
// set ID property of product to be edited


// update the product
if ($intervention->update()) {

// set response code - 200 ok
    http_response_code(200);

// tell the user
    echo json_encode(array("message" => "Intervention was updated."));
} // if unable to update the product, tell the user
else {

// set response code - 503 service unavailable
    http_response_code(503);

// tell the user
    echo json_encode(array("message" => "Unable to update intervention."));
}
?>