<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 09/08/2019
 * Time: 17:56
 */


include_once(__DIR__ . "/../../../autoload.php");


$user=Database::checkUser($_POST["token"]);


if(Database::hotelAdminPower($user->idUser,$_POST["idHotel"])>=200) {
    $a=Database::execute("SELECT idBook, SHA2(BookStripeCode, 256) as bookCode, BookStripeCode=-1 as isFromHotel, User_idUser as idUser,SHA2(User_idUser, 256) AS idUserEncode, (SELECT UserEmail FROM User WHERE idUser=User_idUser) AS UserName, BookDateStart, BookDateEnd, (SELECT RoomName FROM Room WHERE idRoom=Room_idRoom) AS RoomName, ifnull((SELECT SubRoomName FROM SubRoom WHERE SubRoom_idSubRoom=idSubRoom),'000') AS SubRoomName, Room_idRoom as idRoom, BookStripeCode IS NOT NULL AS isPayed FROM Book WHERE (SELECT Hotel_idHotel FROM Room WHERE Room_idRoom=idRoom)=? AND BookDateStart=CURDATE() ORDER BY BookDateStart ASC", array($_POST["idHotel"]));


    $b=Database::execute("SELECT idBook, SHA2(BookStripeCode, 256) as bookCode, BookStripeCode=-1 as isFromHotel, User_idUser as idUser,SHA2(User_idUser, 256) AS idUserEncode, (SELECT UserEmail FROM User WHERE idUser=User_idUser) AS UserName, BookDateStart, BookDateEnd, (SELECT RoomName FROM Room WHERE idRoom=Room_idRoom) AS RoomName, ifnull((SELECT SubRoomName FROM SubRoom WHERE SubRoom_idSubRoom=idSubRoom),'000') AS SubRoomName, Room_idRoom as idRoom, BookStripeCode IS NOT NULL AS isPayed FROM Book WHERE (SELECT Hotel_idHotel FROM Room WHERE Room_idRoom=idRoom)=? AND BookDateStart>CURDATE() ORDER BY BookDateStart ASC", array($_POST["idHotel"]));


    Response::printResponse(true, array("today"=>$a,"tomorrow"=>$b),DONE);

}else{

    Response::printResponse(false, null, ERROR_NOTSPECIFIED);
}
