<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 16/08/2019
 * Time: 15:28
 */


include_once ("../autoload.php");



$a=Database::execute("SELECT idType, IT AS name FROM Type LEFT JOIN Translation ON Type.idTranslation=Translation.idTranslation WHERE idType IN (SELECT Type_idType FROM Room_has_Type_For_Room)");


$b=Database::execute("SELECT idType, IT AS name FROM Type LEFT JOIN Translation ON Type.idTranslation=Translation.idTranslation WHERE idType IN (SELECT Type_For_Hotel_Type_idType FROM Hotel_has_Type_For_Hotel)");



Response::printResponse(true, array("room"=> $a,"hotel"=>$b),DONE);