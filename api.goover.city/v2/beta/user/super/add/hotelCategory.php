<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 12/07/2019
 * Time: 23:22
 */


include_once ("../../../autoload.php");


checkInput(array($_POST["token"],$_POST["categoryName"]));

$user=Database::checkUser($_POST["token"]);



if($user->isSuper){
    Database::execute("INSERT INTO Category(Super_User_idUser, CategoryName) VALUES (?,?)", array($user->idUser,$_POST["categoryName"]));
    Response::printResponse(true, null, DONE);
}else{

    Response::printResponse(false, null, ERROR_NOTSPECIFIED);
}

