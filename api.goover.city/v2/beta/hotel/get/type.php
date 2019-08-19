<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 04/08/2019
 * Time: 15:26
 */



include_once(__DIR__ . "/../../autoload.php");


$ar=Database::execute("SELECT idType, IT AS name FROM Type LEFT JOIN Translation ON Type.idTranslation=Translation.idTranslation WHERE idType IN (SELECT Type_For_Hotel_Type_idType FROM Hotel_has_Type_For_Hotel WHERE Hotel_idHotel=?)", array($_POST["idHotel"]));


Response::printResponse(true, $ar,DONE);
