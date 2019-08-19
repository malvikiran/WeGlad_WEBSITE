<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 12/07/2019
 * Time: 11:14
 */


include_once ("../../../autoload.php");


checkInput(array($_POST["token"],$_POST["HotelName"],$_POST["HotelDesc"],$_POST["HotelLat"],$_POST["HotelLng"]));

$user=Database::checkUser($_POST["token"]);


if($user->isSuper){
    Database::execute("INSERT INTO Hotel(HotelName,HotelDesc,HotelLat,HotelLng,User_idUser,HotelGoogle, HotelAccessible) VALUES(?,?,?,?,?,?,?)",
        array($_POST["HotelName"],$_POST["HotelDesc"],$_POST["HotelLat"],$_POST["HotelLng"],$user->idUser,$_POST["google"],$_POST["toVerify"]));

    Database::execute("INSERT INTO Admin(User_idUser, User_idUser_AddedBy, Hotel_idHotel, AdminPower) VALUES (?,?,(SELECT idHotel FROM Hotel WHERE HotelName=? AND HotelDesc=? AND HotelLat=? AND HotelLng=? AND User_idUser=? AND HotelGoogle=? ORDER BY HotelTime LIMIT 1),200)", array($_POST["admin"],$user->idUser,
        $_POST["HotelName"],$_POST["HotelDesc"],$_POST["HotelLat"],$_POST["HotelLng"],$user->idUser,$_POST["google"]));
    Response::printResponse(true, null, DONE);
}else{

    Response::printResponse(false, null, ERROR_NOTSPECIFIED);
}














