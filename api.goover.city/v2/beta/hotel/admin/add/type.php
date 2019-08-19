<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 27/07/2019
 * Time: 10:31
 */


include_once(__DIR__ . "/../../../autoload.php");



checkInput(array($_POST["token"],$_POST["idType"],$_POST["idHotel"]));


$user=Database::checkUser($_POST["token"]);

if($user->isSuper) {

    $ix=Database::executeFetch("SELECT EXISTS(SELECT * FROM Hotel_has_Type_For_Hotel WHERE Type_For_Hotel_Type_idType=? AND Hotel_idHotel=?) AS es",array($_POST["idType"],$_POST["idHotel"]))["es"];

    if($ix){

        Database::execute("DELETE FROM Hotel_has_Type_For_Hotel WHERE Type_For_Hotel_Type_idType=? AND Hotel_idHotel=?",array($_POST["idType"],$_POST["idHotel"]));
    }else{
        Database::execute("INSERT INTO Hotel_has_Type_For_Hotel(Type_For_Hotel_Type_idType, Hotel_idHotel) VALUES (?,?)",array($_POST["idType"],$_POST["idHotel"]));

    }



    Response::printResponse(true, null,DONE);
}

