<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 29/07/2019
 * Time: 17:07
 */


include_once ("../../../../autoload.php");

checkInput(array($_POST["token"],$_POST["idRoom"]));

$user=Database::checkUser($_POST["token"]);



if(Database::roomAdminPower($user->idUser,$_POST["idRoom"])>=200) {
    $costs=Database::execute("SELECT RoomCost, SubRoom_PriceEnd, SubRoom_PriceStart, SubRoom_PriceCost FROM Room LEFT JOIN  SubRoom ON Room.idRoom=SubRoom.Room_idRoom LEFT JOIN (SELECT * FROM SubRoom_Price WHERE SubRoom_PriceEnd>NOW()) AS SubRoom_Price ON SubRoom_Price.Room_idRoom=SubRoom.Room_idRoom WHERE idRoom=? GROUP BY SubRoom.Room_idRoom ORDER BY SubRoom_PriceStart", array($_POST["idRoom"]));


    Response::printResponse(true, $costs, DONE);
}else{

    Response::printResponse(false, null, ERROR_NOTSPECIFIED);
}