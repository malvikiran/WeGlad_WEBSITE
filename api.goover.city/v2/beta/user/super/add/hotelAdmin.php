<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 12/07/2019
 * Time: 23:22
 */


include_once ("../../../autoload.php");


checkInput(array($_POST["token"],$_POST["userEmail"],$_POST["hotelId"]));

$user=Database::checkUser($_POST["token"]);



if($user->isSuper){
    Database::execute("INSERT INTO Admin(User_idUser, User_idUser_AddedBy, Hotel_idHotel, AdminPower) VALUES ((SELECT idUser FROM User WHERE UserEmail=?),?,?,200)", array($_POST["userEmail"],$user->idUser,$_POST["hotelId"]));
    Response::printResponse(true, null, DONE);
}else{

    Response::printResponse(false, null, ERROR_NOTSPECIFIED);
}

