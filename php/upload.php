<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 20.08.18
 * Time: 22:46
 */

$json_response = array(
    "code" => "",
    "text" => ""
);

$fileName = $_FILES["fileload"]["name"];
$fileTmpLoc = $_FILES["fileload"]["tmp_name"];
$fileType = $_FILES["fileload"]["type"];
$fileSize = $_FILES["fileload"]["size"];
$fileErrorMsg = $_FILES["fileload"]["error"];

if (!$fileTmpLoc) {
    $json_response["text"] = "ERROR!!!";
    exit();
}

if (move_uploaded_file($fileTmpLoc, "uploads/$fileName")) {
    $json_response["code"] = 200;
    $json_response["text"] = "$fileName upload is complete";
} else {
    $json_response["code"] = 333;
    $json_response["text"] = "move_uploaded_file function failed";
}

echo json_encode( $json_response );
