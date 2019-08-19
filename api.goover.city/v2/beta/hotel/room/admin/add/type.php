<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 27/07/2019
 * Time: 10:31
 */


include_once(__DIR__ . "/../../../../autoload.php");



checkInput(array($_POST["token"],$_POST["idType"],$_POST["idRoom"]));


$user=Database::checkUser($_POST["token"]);

if($user->isSuper) {

    $ix=Database::executeFetch("SELECT EXISTS(SELECT * FROM Room_has_Type_For_Room WHERE Type_idType=? AND Room_idRoom=?) AS es",array($_POST["idType"],$_POST["idRoom"]))["es"];

    if($ix){

        Database::execute("DELETE FROM Room_has_Type_For_Room WHERE Type_idType=? AND Room_idRoom=?",array($_POST["idType"],$_POST["idRoom"]));
    }else{
        Database::execute("INSERT INTO Room_has_Type_For_Room(Type_idType, Room_idRoom) VALUES (?,?)",array($_POST["idType"],$_POST["idRoom"]));

    }



    Response::printResponse(true, null,DONE);
}

