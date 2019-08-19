<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 04/08/2019
 * Time: 14:02
 */



include_once(__DIR__ . "/../autoload.php");


$ar=Database::executeFetch("SELECT idHotel, HotelName, HotelDesc, HotelLat, HotelLng, HotelCheckIn, HotelCheckOut, HotelStar FROM Hotel WHERE idHotel=?",array($_POST["idHotel"]));

Response::printResponse(true, $ar, DONE);