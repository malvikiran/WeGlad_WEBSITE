<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 27/07/2019
 * Time: 10:31
 */


include_once(__DIR__ . "/../../autoload.php");


$user=Database::checkUser($_POST["token"]);



if(isset($_POST["image"])){
    $imageCode=Database::uploadImage($user,$_POST["image"]);
}else{
    $imageCode=null;
}

Database::execute("INSERT INTO Feedback(Map_idMap, User_idUser, Image_idImage,FeedbackUp, FeedbackDesc) VALUES (?,?,?,?,?)",array($_POST["idMap"],$user->idUser,$imageCode,$_POST["isPresent"]=="true",$_POST["comment"]));

    Response::printResponse(true, $ar,DONE);



