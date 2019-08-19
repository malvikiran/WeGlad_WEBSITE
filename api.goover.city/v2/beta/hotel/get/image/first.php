<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 13/07/2019
 * Time: 00:09
 */

include_once ("../../../autoload.php");


$data=Database::executeFetch("SELECT ImageFile,ImageExt FROM Image WHERE idImage=(SELECT Image_idImage FROM Hotel_has_Image WHERE Hotel_idHotel=? ORDER BY `order` ASC LIMIT 1) ", array($_GET["idHotel"]));



if(isset($data["ImageExt"])){
    header("Content-type: ".explode(";",explode(":",$data["ImageExt"])[1])[0]);
}else{
    header("Content-type: image/png");
}

if(isset($data["ImageFile"])){

    echo base64_decode($data["ImageFile"]);
}else{

    echo file_get_contents("https://images.unsplash.com/photo-1528920304568-7aa06b3dda8b?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&w=1000&q=80");
}

