<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 14/08/2019
 * Time: 12:44
 */



include_once(__DIR__ . "/../../../autoload.php");

checkInput(array($_POST["token"],$_POST["dateStart"],$_POST["dateEnd"],$_POST["idhotel"],$_POST["selectRoom"]));


$user=Database::checkUser($_POST["token"]);

if(isset($_POST["selectSubRoom"])){
    Database::executeFetch("INSERT INTO Book(BookDateStart, BookDateEnd, Room_idRoom, User_idUser, BookStripeCode, SubRoom_idSubRoom) VALUES (?,?,(SELECT idRoom FROM Room WHERE Hotel_idHotel=? AND idRoom=?),?,-1,?)",array(

        $_POST["dateStart"],$_POST["dateEnd"],$_POST["idhotel"],$_POST["selectRoom"],
        $user->idUser,$_POST["selectSubRoom"]));
}else{
    Database::executeFetch("INSERT INTO Book(BookDateStart, BookDateEnd, Room_idRoom, User_idUser, BookStripeCode) VALUES (?,?,(SELECT idRoom FROM Room WHERE Hotel_idHotel=? AND idRoom=?),?,-1)",array(

        $_POST["dateStart"],$_POST["dateEnd"],$_POST["idhotel"],$_POST["selectRoom"],
        $user->idUser));
}


Response::printResponse(true, null, DONE);
