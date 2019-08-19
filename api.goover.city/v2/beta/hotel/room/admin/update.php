<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 06/08/2019
 * Time: 17:43
 */

include_once(__DIR__ . "/../../../autoload.php");



checkInput(array($_POST["token"],$_POST["name"],$_POST["desc"],$_POST["money"],$_POST["roomId"]));

$user=Database::checkUser($_POST["token"]);

$hotelId=Database::executeFetch("SELECT Hotel_idHotel From Room where idRoom=?", array($_POST["roomId"]))["Hotel_idHotel"];

if(Database::hotelAdminPower($user->idUser,$hotelId)>=200) {


    Database::execute("UPDATE Room SET RoomName=?, RoomDesc=?, RoomCost=?, RoomAccessible=?, RoomAdult=?, RoomChild=? WHERE idRoom=?", array($_POST["name"],$_POST["desc"],$_POST["money"],$_POST["accessible"]=="true"?1:0,$_POST["adult"],$_POST["child"],$_POST["roomId"]));

    Response::printResponse(true, null, DONE);
}else{

    Response::printResponse(false, null, ERROR_NOTSPECIFIED);
}
