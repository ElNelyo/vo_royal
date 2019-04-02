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

    } // if unable to update the product, tell the use
}
else{

    // set response code - 404 Not found
    http_response_code(404);

    // tell the user no familles found
    echo json_encode(
        array("message" => "No intervention found.")
    );
}
