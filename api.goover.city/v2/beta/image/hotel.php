<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 13/07/2019
 * Time: 00:09
 */

include_once ("../autoload.php");


$data=Database::executeFetch("SELECT ImageFile,ImageExt FROM Image WHERE idImage=(SELECT Image_idImage FROM Hotel_has_Image WHERE Image_idImage=?)", array($_GET["image"]));


if(isset($data["ImageExt"])){
    header("Content-type: ".explode(";",explode(":",$data["ImageExt"])[1])[0]);
}else{
    header("Content-type: image/png");
}

echo base64_decode($data["ImageFile"]);
