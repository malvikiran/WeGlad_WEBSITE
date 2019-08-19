<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 29/07/2019
 * Time: 01:28
 */


include_once(__DIR__ . "/../../../../autoload.php");

$user=Database::checkUser($_POST["token"]);

$order=json_decode($_POST["order"]);

$inta=0;
foreach ($order as $sic){
    Database::execute("UPDATE Room_has_Image SET `order`=? WHERE Image_idImage=? AND Room_idRoom=?", array($inta,$sic,$_POST["idRoom"]));
    $inta++;
}




Response::printResponse(true, null,DONE);

