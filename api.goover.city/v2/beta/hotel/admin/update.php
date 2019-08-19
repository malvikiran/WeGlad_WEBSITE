<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 06/08/2019
 * Time: 17:43
 */

include_once(__DIR__ . "/../../autoload.php");



checkInput(array($_POST["token"],$_POST["name"],$_POST["desc"],$_POST["checkin"],$_POST["checkout"],$_POST["stars"],$_POST["idHotel"]));

$user=Database::checkUser($_POST["token"]);



if(Database::hotelAdminPower($user->idUser,$_POST["idHotel"])>=200) {


    Database::execute("UPDATE Hotel SET HotelName=?, HotelDesc=?, HotelCheckIn=?, HotelCheckOut=?, HotelStar=? WHERE idHotel=?", array($_POST["name"],$_POST["desc"],$_POST["checkin"],$_POST["checkout"],$_POST["stars"],$_POST["idHotel"]));

    Response::printResponse(true, null, DONE);
}else{

    Response::printResponse(false, null, ERROR_NOTSPECIFIED);
}
