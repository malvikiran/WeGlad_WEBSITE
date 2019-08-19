<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 12/07/2019
 * Time: 23:36
 */

include_once ("../../../../autoload.php");

checkInput(array($_POST["token"],$_POST["image"],$_POST["idRoom"]));

$user=Database::checkUser($_POST["token"]);



if(Database::roomAdminPower($user->idUser,$_POST["idRoom"])>=200) {


    $idImage=Database::uploadImage($user,$_POST["image"]);
    Database::execute("INSERT INTO Room_has_Image(Room_idRoom, Image_idImage) VALUES (?,?)", array($_POST["idRoom"], $idImage));

    Response::printResponse(true, null, DONE);
}else{

    Response::printResponse(false, null, ERROR_NOTSPECIFIED);
}