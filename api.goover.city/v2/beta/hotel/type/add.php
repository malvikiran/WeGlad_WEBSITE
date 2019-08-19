<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 27/07/2019
 * Time: 10:31
 */


include_once(__DIR__ . "/../../autoload.php");



checkInput(array($_POST["token"],$_POST["image"],$_POST["idTrans"]));


$user=Database::checkUser($_POST["token"]);

if($user->isSuper) {
    $imageCode=Database::uploadImage($user,$_POST["image"]);
    $ar = Database::execute("INSERT INTO Type(Super_User_idUser, idTranslation, IMAGE_idImage) VALUES (?,?,?)",array($user->idUser,$_POST["idTrans"],$imageCode));

    Database::execute("INSERT INTO Type_For_Hotel(Type_idType) (SELECT idType FROM Type WHERE Super_User_idUser=? AND idTranslation=? AND IMAGE_idImage=?)",array($user->idUser,$_POST["idTrans"],$imageCode));



    Response::printResponse(true, null,DONE);
}

