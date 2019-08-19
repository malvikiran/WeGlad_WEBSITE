<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 04/08/2019
 * Time: 15:26
 */



include_once(__DIR__ . "/../../../../autoload.php");


$ar=Database::execute("SELECT idType, IT AS name, idType IN (SELECT Type_idType FROM Room_has_Type_For_Room WHERE Room_idRoom=?) AS isSel FROM Type LEFT JOIN Translation ON Type.idTranslation=Translation.idTranslation WHERE idType IN (SELECT Type_idType FROM Type_For_Hotel WHERE Type_idType IN (SELECT Type_For_Hotel_For_Room.Type_idType FROM Type_For_Hotel_For_Room))", array($_POST["idRoom"]));


Response::printResponse(true, $ar,DONE);

