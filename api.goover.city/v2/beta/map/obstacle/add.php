<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 27/07/2019
 * Time: 10:31
 */


include_once(__DIR__ . "/../../autoload.php");

$temp=uniqid();
if($_POST["comment"]==""){
    $_POST["comment"]=$temp;
}


checkInput(array($_POST["token"],$_POST["isSuperable"],$_POST["lat"],$_POST["lng"],$_POST["image"],$_POST["comment"]));


if($_POST["comment"]==$temp){
    $_POST["comment"]=null;
}


$user=Database::checkUser($_POST["token"]);

$ar = Database::execute("INSERT INTO Map(User_idUser, MapLat, MapLng, MapOvercome) VALUES (?,?,?,?)",array($user->idUser,$_POST["lat"],$_POST["lng"],$_POST["isSuperable"]));
Database::execute("INSERT INTO Map_has_Type(idMap, idType) VALUES ((SELECT Map.idMap FROM Map WHERE User_idUser=? AND MapLat=? AND MapLng=? AND MapOvercome=?),?)", Array($user->idUser,$_POST["lat"],$_POST["lng"],$_POST["isSuperable"],$_POST["type"]));
$banana=Database::executeFetch("SELECT idMap FROM Map WHERE User_idUser=? AND MapLat=? AND MapLng=? AND MapOvercome=? ORDER BY MapTime DESC LIMIT 1",array($user->idUser,$_POST["lat"],$_POST["lng"],$_POST["isSuperable"]))["idMap"];

$imageCode=Database::uploadImage($user,$_POST["image"]);

Database::execute("INSERT INTO Feedback(Map_idMap, User_idUser, Image_idImage,FeedbackUp, FeedbackDesc) VALUES (?,?,?,1,?)",array($banana,$user->idUser,$imageCode,$_POST["comment"]));

Response::printResponse(true, null,DONE);

