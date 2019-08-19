<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 27/07/2019
 * Time: 10:31
 */


include_once(__DIR__ . "/../../../autoload.php");

$user=Database::checkUser($_POST["token"]);



$ar=Database::execute("SELECT idHotel,HotelName, HotelDesc, HotelLng, HotelLat, HotelCheckOut, HotelCheckIn, HotelStar, HotelAccessible, HotelStripe IS NOT NULL AND HotelEnabled>0 AS isEnabled, HotelStripe IS NOT NULL AS verified FROM Hotel WHERE idHotel IN (SELECT Hotel_idHotel FROM Admin WHERE Admin.User_idUser=?)", array($user->idUser));


Response::printResponse(true, $ar,DONE);

