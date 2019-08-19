<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 27/07/2019
 * Time: 10:31
 */


include_once(__DIR__ . "/../../../autoload.php");


$ar=Database::execute("SELECT idType, IT AS name FROM Type LEFT JOIN Translation ON Type.idTranslation=Translation.idTranslation WHERE idType NOT IN (SELECT Type_idType FROM Type_For_Hotel)");


Response::printResponse(true, $ar,DONE);

