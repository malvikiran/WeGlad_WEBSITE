<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 29/07/2019
 * Time: 19:24
 */


include_once ("../../../../autoload.php");

checkInput(array($_POST["token"],$_POST["idRoom"],$_POST["dataStart"],$_POST["dataEnd"],$_POST["cost"]));

$user=Database::checkUser($_POST["token"]);



if(Database::roomAdminPower($user->idUser,$_POST["idRoom"])>=200) {

    Database::prepareCommit();

    try {
        Database::execute("DELETE FROM SubRoom_Price WHERE SubRoom_PriceStart=? AND SubRoom_PriceEnd=? AND SubRoom_PriceCost=? AND Room_idRoom=?", array($_POST["dataStart"],$_POST["dataEnd"],$_POST["cost"],$_POST["idRoom"]));
        Database::execute("UPDATE SubRoom_Price SET SubRoom_PriceEnd=(STR_TO_DATE(?,'%Y-%m-%d') - INTERVAL 1 DAY) WHERE SubRoom_PriceStart<? AND ?<=SubRoom_PriceEnd AND Room_idRoom=?",array($_POST["dataStart"],$_POST["dataStart"],$_POST["dataStart"],$_POST["idRoom"]));
        Database::execute("UPDATE SubRoom_Price SET SubRoom_PriceStart=(STR_TO_DATE(?,'%Y-%m-%d') + INTERVAL 1 DAY) WHERE SubRoom_PriceStart<=? AND ?<SubRoom_PriceEnd AND Room_idRoom=?",array($_POST["dataEnd"],$_POST["dataEnd"],$_POST["dataEnd"],$_POST["idRoom"]));
        Database::execute("INSERT INTO SubRoom_Price(Room_idRoom,SubRoom_PriceStart, SubRoom_PriceEnd, SubRoom_PriceCost) VALUES (?,?,?,?)",array($_POST["idRoom"],$_POST["dataStart"],$_POST["dataEnd"],$_POST["cost"]));

        Database::doCommit();
    } catch (PDOException $e) {
        Database::rollBack();
    }



    Response::printResponse(true, null, DONE);
}else{

    Response::printResponse(false, null, ERROR_NOTSPECIFIED);
}
