<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 11/07/2019
 * Time: 19:11
 */

include_once ("../../../autoload.php");


checkInput(array($_GET["token"],$_GET["userCode"]));

$id=Database::checkUser($_GET["token"]);

$data=Database::executeFetch("SELECT ImageFile,ImageExt FROM Image WHERE idImage=(SELECT Image_idImage FROM User where SHA2(idUser, 256)=?)", array($_GET["userCode"]));


if(isset($data["ImageExt"])){
    header("Content-type: ".explode(";",explode(":",$data["ImageExt"])[1])[0]);
}else{
    header("Content-type: image/png");
}

if(isset($data["ImageFile"])){

    echo base64_decode($data["ImageFile"]);
}else{
    echo file_get_contents("https://static05.cminds.com/wp-content/uploads/computer-1331579_1280-1-300x300.png");
}
