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


    if(isset($_POST["image"])&&$_POST["image"]!=null){
        $imageCode=Database::uploadImage($user,$_POST["image"]);
        $ar = Database::execute("UPDATE Type SET IMAGE_idImage=? where idType=?",array($imageCode,$_POST["idType"]));

    }
    if(isset($_POST["idTrans"])&&$_POST["idTrans"]!=null) {

        $ar = Database::execute("UPDATE Type SET idTranslation=? where idType=?", array($_POST["idTrans"], $_POST["idType"]));
    }
    Response::printResponse(true, null,DONE);
}

