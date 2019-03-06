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
$interventionObject = new Intervention($db);
$interventionObject= $interventionObject->get($_GET['id']);
$new_Intervention = new Intervention($db);
$intervention = $interventionObject->fetch(PDO::FETCH_ASSOC);
$new_Intervention->id=$intervention["id"];
$new_Intervention->titre=$intervention["titre"];
$new_Intervention->priorite=$intervention["priorite"];
$new_Intervention->detail=$intervention["detail"];
$new_Intervention->personne=$intervention["personne"];


// get id of product to be edited
$data = json_decode(file_get_contents("php://input"));
if (isset($_GET)) {
    if ( (isset($_GET['titre']) && $_GET['titre'] != "" )) {
        $new_Intervention->titre = $_GET['titre'];
    }


    if ( (isset($_GET['priorite']) && $_GET['priorite'] != "" )) {

        $new_Intervention->priorite = $_GET['priorite'];
    }

    if ( (isset($_GET['detail']) && $_GET['detail'] != "" )) {

        $new_Intervention->detail = $_GET['detail'];
    }

    if ( (isset($_GET['personne']) && $_GET['personne'] != "" )) {


        $new_Intervention->personne = $_GET['personne'];
    }
// set product property values

}
// set ID property of product to be edited


// update the product
if ($new_Intervention->update()) {

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