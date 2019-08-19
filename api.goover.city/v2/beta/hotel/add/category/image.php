<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 13/07/2019
 * Time: 00:42
 */

include_once ("../../../autoload.php");

checkInput(array($_POST["token"],$_POST["image"],$_POST["idHotel"],$_POST["idCategory"]));

$user=Database::checkUser($_POST["token"]);

try{

    $idImage=Database::uploadImage($user,$_POST["image"]);
    Database::execute("INSERT INTO Hotel_has_Image_has_Category_User(Hotel_idHotel, Image_idImage, Category_idCategory, User_idUser) VALUES (?,?,?,?)", array($_POST["idHotel"], $idImage,$_POST["idCategory"],$user->idUser));

    Response::printResponse(true, null, DONE);
}catch (Exception $e){

    Response::printResponse(false, null, ERROR_NOTSPECIFIED);
}