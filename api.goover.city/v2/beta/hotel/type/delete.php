<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 27/07/2019
 * Time: 10:31
 */


include_once(__DIR__ . "/../../autoload.php");



checkInput(array($_POST["token"],$_POST["idType"]));


$user=Database::checkUser($_POST["token"]);

if($user->isSuper) {


    Database::execute("DELETE FROM Type WHERE  Type.idType=?",array($_POST["idType"]));

    Response::printResponse(true, null,DONE);
}

