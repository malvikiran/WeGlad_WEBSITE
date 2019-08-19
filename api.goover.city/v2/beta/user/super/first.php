<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 12/07/2019
 * Time: 11:06
 */

include_once ("../../autoload.php");


checkInput(array($_POST["token"]));

$user=Database::checkUser($_POST["token"]);


Database::executeFetch("INSERT INTO Super (User_idUser) VALUES (?)", array($user->idUser));

Response::printResponse(true, null, DONE);