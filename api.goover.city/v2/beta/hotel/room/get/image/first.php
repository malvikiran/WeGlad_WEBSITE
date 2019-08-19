<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 13/07/2019
 * Time: 00:09
 */

include_once ("../../../../autoload.php");


$data=Database::executeFetch("SELECT ImageFile,ImageExt FROM Image WHERE idImage=(SELECT Image_idImage FROM Room_has_Image WHERE Room_idRoom=? ORDER BY `order` ASC LIMIT 1) ", array($_GET["idRoom"]));



if(isset($data["ImageExt"])){
    header("Content-type: ".explode(";",explode(":",$data["ImageExt"])[1])[0]);
}else{
    header("Content-type: image/png");
}

if(isset($data["ImageFile"])){

    echo base64_decode($data["ImageFile"]);
}else{

    echo file_get_contents("https://img2.cgtrader.com/items/826675/229135006e/empty-room-3d-model-blend.jpg");
}

