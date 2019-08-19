<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 13/07/2019
 * Time: 00:09
 */

include_once ("../../../autoload.php");


$data=Database::executeFetch("SELECT ImageFile,ImageExt FROM Image WHERE idImage=(SELECT Image_idImage FROM Feedback WHERE Map_idMap=? AND idFeedback=?)", array($_GET["idMap"],$_GET["idFeedback"]));


if(isset($data["ImageExt"])){
    header("Content-type: ".explode(";",explode(":",$data["ImageExt"])[1])[0]);
}else{
    header("Content-type: image/png");
}

echo base64_decode($data["ImageFile"]);
