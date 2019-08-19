<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 12/07/2019
 * Time: 23:36
 */

include_once ("../../../autoload.php");

checkInput(array($_POST["token"],$_POST["image"],$_POST["idHotel"]));

$user=Database::checkUser($_POST["token"]);



if(Database::hotelAdminPower($user->idUser,$_POST["idHotel"])>=200) {


    $idImage=Database::uploadImage($user,$_POST["image"]);
    Database::execute("INSERT INTO Hotel_has_Image(Hotel_idHotel, Image_idImage) VALUES (?,?)", array($_POST["idHotel"], $idImage));

    Response::printResponse(true, null, DONE);
}else{

    Response::printResponse(false, null, ERROR_NOTSPECIFIED);
}