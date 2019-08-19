<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 27/07/2019
 * Time: 11:21
 */


include_once(__DIR__ . "/../../../../autoload.php");


include_once ("../../../../autoload.php");


$user=Database::checkUser($_POST["token"]);

if(Database::hotelAdminPower($user->idUser,$_POST["idHotel"])>=200) {





    Database::execute("INSERT INTO Room(Hotel_idHotel, RoomName, RoomDesc, RoomCost, RoomAccessible, RoomAdult, RoomChild)  VALUES (?,?,?,?,?,?,?)", array($_POST["idHotel"], $_POST["name"],$_POST["desc"],$_POST["money"],$_POST["accessible"],$_POST["adult"],$_POST["child"]));


    $dat=Database::executeFetch("SELECT idRoom FROM Room WHERE Hotel_idHotel=? and RoomName=? AND  RoomDesc=? AND  RoomCost=? AND  RoomAccessible=? ORDER BY RoomTime DESC LIMIT 1", array($_POST["idHotel"], $_POST["name"],$_POST["desc"],$_POST["money"],$_POST["accessible"]))["idRoom"];

    $rooms=json_decode($_POST["rooms"],true);

    $i=0;
    foreach ($rooms as $key=>$value){
        Database::execute("INSERT INTO SubRoom(Room_idRoom, SubRoomName) VALUES (?,?)", array($dat,$value));
        $i++;
    }
    Database::execute("INSERT INTO SubRoom_Price(Room_idRoom,SubRoom_PriceStart, SubRoom_PriceEnd, SubRoom_PriceCost) VALUES (?,'2000-01-01','2000-01-01',6.66)",array($dat));


    Response::printResponse(true, null, DONE);
}else{

    Response::printResponse(false, null, ERROR_NOTSPECIFIED);
}
