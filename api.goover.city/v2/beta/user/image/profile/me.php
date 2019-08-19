<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 11/07/2019
 * Time: 19:11
 */

include_once ("../../../autoload.php");


checkInput(array($_POST["token"]));

$id=Database::checkUser($_POST["token"]);

$data=Database::executeFetch("SELECT ImageFile,ImageExt FROM Image WHERE idImage=(SELECT Image_idImage FROM User where idUser=?)", array($id->idUser));


if(isset($data["ImageExt"])){
    header("Content-type: ".explode(";",explode(":",$data["ImageExt"])[1])[0]);
}else{
    header("Content-type: image/png");
}

echo base64_decode($data["ImageFile"]);
