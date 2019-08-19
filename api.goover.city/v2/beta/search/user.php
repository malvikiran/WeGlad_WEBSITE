<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 13/07/2019
 * Time: 00:17
 */



include_once ("../autoload.php");
checkInput(array($_POST["token"],$_GET["q"]));

$user=Database::checkUser($_POST["token"]);


if($user->isSuper){
    $output = Database::execute("SELECT idUser, UserName, UserEmail FROM User WHERE LOCATE(?,UserEmail)>0 order by LOCATE(?,UserEmail)", array($_GET["q"],$_GET["q"]));

    Response::printResponse(true, $output, DONE);
}else{

    Response::printResponse(false, null, ERROR_NOTSPECIFIED);
}



