<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 16/08/2019
 * Time: 15:20
 */

include_once(__DIR__ . "/../../../autoload.php");

checkInput(array($_POST["token"],$_POST["idHotel"]));

$user=Database::checkUser($_POST["token"]);



if(Database::hotelAdminPower($user->idUser,$_POST["idHotel"])>=200) {


    Database::execute("UPDATE Hotel SET HotelEnabled=1-HotelEnabled WHERE idHotel=?", array($_POST["idHotel"]));

    Response::printResponse(true, null, DONE);
}else{

    Response::printResponse(false, null, ERROR_NOTSPECIFIED);
}
