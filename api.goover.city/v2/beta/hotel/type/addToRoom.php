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

    $ix=Database::executeFetch("SELECT EXISTS(SELECT * FROM Type_For_Hotel_For_Room WHERE Type_idType=?) AS es",array($_POST["idType"]))["es"];

    if($ix){

        Database::execute("DELETE FROM Type_For_Hotel_For_Room WHERE Type_idType=?",array($_POST["idType"]));
    }else{
        Database::execute("INSERT INTO Type_For_Hotel_For_Room(Type_idType) VALUES (?)",array($_POST["idType"]));

    }



    Response::printResponse(true, null,DONE);
}

