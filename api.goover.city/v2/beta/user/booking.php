<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 15/08/2019
 * Time: 02:12
 */


include_once ("../autoload.php");

$user=Database::checkUser($_POST["token"]);

$a=Database::execute("SELECT idBook, idRoom, RoomName, BookDateStart, BookDateEnd, HotelName, idHotel  FROM Book INNER JOIN Room ON idRoom=Room_idRoom INNER JOIN Hotel H on Room.Hotel_idHotel = H.idHotel WHERE BookDateEnd>NOW() AND Book.User_idUser=? ORDER BY BookDateStart",array($user->idUser));

Response::printResponse(true, $a,DONE);