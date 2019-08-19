<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 15/08/2019
 * Time: 00:02
 */


include_once ("../../../autoload.php");


checkInput(array($_POST["token"]));

$user=Database::checkUser($_POST["token"]);

$a=Database::execute("SELECT idUser,SHA2(idUser,256) as idUserEncode, UserEmail, UserName FROM User WHERE  LOCATE(?, UserEmail)>0", array($_POST["q"]));


Response::printResponse(true,$a,DONE);
