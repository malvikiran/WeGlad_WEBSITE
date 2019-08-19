<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 13/07/2019
 * Time: 00:30
 */


include_once ("../../../../autoload.php");

checkInput(array($_POST["token"],$_POST["image"],$_POST["idHotel"],$_POST["categoryId"]));

$user=Database::checkUser($_POST["token"]);

if(Database::hotelAdminPower($user->idUser,$_POST["idHotel"])>=200) {

    $idImage=Database::uploadImage($user,$_POST["image"]);
    Database::execute("INSERT INTO Hotel_has_Image_has_Category(Hotel_idHotel, Image_idImage, Category_idCategory) VALUES (?,?,?)", array($_POST["idHotel"], $idImage,$_POST["categoryId"]));

    Response::printResponse(true, null, DONE);
}else{

    Response::printResponse(false, null, ERROR_NOTSPECIFIED);
}