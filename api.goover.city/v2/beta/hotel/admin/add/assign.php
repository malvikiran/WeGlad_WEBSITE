<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 14/08/2019
 * Time: 12:44
 */



include_once(__DIR__ . "/../../../autoload.php");

checkInput(array($_POST["token"],$_POST["selectRoom"],$_POST["idBook"],$_POST["idHotel"]));


$user=Database::checkUser($_POST["token"]);

if(isset($_POST["selectSubRoom"])){
    Database::executeFetch("UPDATE Book SET Room_idRoom=? , SubRoom_idSubRoom=? WHERE idBook=? AND Room_idRoom IN (SELECT idRoom FROM Room WHERE Hotel_idHotel=?)",array(

        $_POST["selectRoom"],$_POST["selectSubRoom"],$_POST["idBook"],$_POST["idHotel"]
    ));
}else{
    Database::executeFetch("UPDATE Book SET Room_idRoom=? , SubRoom_idSubRoom=NULL WHERE idBook=? AND Room_idRoom IN (SELECT idRoom FROM Room WHERE Hotel_idHotel=?)",array(

        $_POST["selectRoom"],$_POST["idBook"],$_POST["idHotel"]
    ));
}


Response::printResponse(true, null, DONE);
