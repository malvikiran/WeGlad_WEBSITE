<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 11/07/2019
 * Time: 16:01
 */


include_once ("../autoload.php");

checkInput(array($_POST["token"]));



try{
    $result= Database::executeFetch("SELECT SHA2(idUser, 256) AS UserCode, UserName, UserEmailVerify IS NULL AS UserEmailVerify, IF(idUser IN (SELECT User_idUser FROM Super),1,0) AS isSuper, IF(idUser IN (SELECT User_idUser FROM Admin WHERE AdminPower>0),1,0) AS isAdmin FROM User WHERE idUser=? AND UserToken=?",array(SipioToken::extractIdUtente($_POST["token"]),$_POST["token"]));

    if(isset($result["UserCode"])){

        Response::printResponse(true,$result,DONE);
    }else{

        Response::printResponse(false,null,ERROR_WRONGTOKEN);
    }

}catch (Exception $e){
    Response::printResponse(false,null,ERROR_WRONGTOKEN);
}

