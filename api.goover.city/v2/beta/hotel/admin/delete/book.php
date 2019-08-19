<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 14/08/2019
 * Time: 12:44
 */



include_once(__DIR__ . "/../../../autoload.php");

checkInput(array($_POST["token"],$_POST["idBook"],$_POST["idHotel"]));


$user=Database::checkUser($_POST["token"]);

    Database::executeFetch("DELETE FROM Book WHERE idBook=? AND Room_idRoom IN(SELECT idRoom FROM Room WHERE Hotel_idHotel=?) AND BookStripeCode=-1",array(

        $_POST["idBook"],$_POST["idHotel"]));


Response::printResponse(true, null, DONE);
