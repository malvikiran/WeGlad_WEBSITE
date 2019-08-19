<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 27/07/2019
 * Time: 10:31
 */


include_once(__DIR__ . "/../../../autoload.php");

$user=Database::checkUser($_POST["token"]);


$ar=Database::execute("SELECT idRoom, RoomName, RoomDesc, RoomCost,RoomAccessible, COUNT(idSubRoom) as N, RoomAdult, RoomChild FROM Room LEFT JOIN SubRoom S on Room.idRoom = S.Room_idRoom WHERE Hotel_idHotel IN (SELECT Admin.Hotel_idHotel FROM Admin WHERE Admin.User_idUser=?) AND Hotel_idHotel=? GROUP BY idRoom", array($user->idUser,$_POST["idHotel"]));


Response::printResponse(true, $ar,DONE);

