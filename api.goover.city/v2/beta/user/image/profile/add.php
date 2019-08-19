<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 11/07/2019
 * Time: 19:08
 */


include_once ("../../../autoload.php");

checkInput(array($_POST["token"],$_POST["image"]));

$id=Database::checkUser($_POST["token"]);

$imageCode=Database::uploadImage($id,$_POST["image"]);

Database::execute("UPDATE User SET Image_idImage=? Where idUser=?",array($imageCode,$id->idUser));



Response::printResponse(true,null,DONE);