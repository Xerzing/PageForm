<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 20.08.18
 * Time: 22:46
 */

require_once('form.php');

$json_response = array(
    "code" => "",
    "text" => "",
    "err_name" => "",
    "err_email" => "",
    "err_address" => "",
    "err_index" => "",
    "error" => "",
);

$json_response['err_name'] = $checkValid->getNameError();
$json_response['err_email'] = $checkValid->getEmailError();
$json_response['err_address'] = $checkValid->getAddressError();
$json_response['err_index'] = $checkValid->getPostIndexError();


$fileName = $_FILES["fileload"]["name"];
$fileTmpLoc = $_FILES["fileload"]["tmp_name"];
$fileType = $_FILES["fileload"]["type"];
$fileSize = $_FILES["fileload"]["size"];
$fileErrorMsg = $_FILES["fileload"]["error"];

if (!$fileTmpLoc) {
    $json_response["text"] = "ERROR!!!";
    exit();
}

if(!is_dir('uploads')){
    mkdir('uploads', 0777, true);
}

$no_err_empty = (bool) array_filter($json_response);

if (move_uploaded_file($fileTmpLoc, "uploads/$fileName") && !$no_err_empty) {
    $json_response["code"] = 200;
    $json_response["text"] = "Завантаження успішне";
} elseif ($no_err_empty) {
    $json_response["code"] = 333;
    $json_response["text"] = "Помилка форми";
}  else {
    $json_response["code"] = 333;
    $json_response["text"] = "Помилка завантаження";
}

echo json_encode($json_response, JSON_UNESCAPED_UNICODE);
