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
    $intervention = new Intervention ($db);

// query familles
    $stmt = $intervention->read();
    $num = $stmt->rowCount();


// check if more than 0 record found
    if ($num > 0) {

        // familles array
        $intervention_arr = array();
        $intervention_arr["records"] = array();

        // retrieve our table contents
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // extract row
            // this will make $row['name'] to
            // just $name only
            extract($row);
            $intervention_obj = array(
                "id" => $id,
                "titre" => $titre,
                "detail" => $detail,
                "priorite" => $priorite,
                "personne" => $personne
            );

            array_push($intervention_arr["records"], $intervention_obj);
        }

        // set response code - 200 OK
        http_response_code(200);

        // show familles data in json format
        echo json_encode($intervention_arr);

    } // if unable to update the product, tell the user
    else {

// set response code - 503 service unavailable
        http_response_code(503);

// tell the user
        echo json_encode(array("message" => "Unable to update intervention."));
    }
}
?>