<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 11/07/2019
 * Time: 16:01
 */


include_once ("../autoload.php");

checkInput(array($_POST["email"],$_POST["password"]));


try{
    $result= Database::executeFetch("SELECT idUser  FROM User WHERE UserEmail=? AND UserPassword=SHA2(CONCAT(?, UserSalt), 256)",array($_POST["email"],$_POST["password"]));


    Database::execute("UPDATE User SET UserToken=? WHERE idUser=?",array(SipioToken::createToken($result["idUser"]),$result["idUser"]));


    $result= Database::executeFetch("SELECT SHA2(idUser, 256) AS UserCode,UserName, UserEmailVerify IS NULL AS UserEmailVerify, UserToken, idUser IN(SELECT idUser FROM Super) AS isSuper, IF(idUser IN (SELECT User_idUser FROM Admin WHERE AdminPower>0),1,0) AS isAdmin FROM User WHERE UserEmail=? AND UserPassword=SHA2(CONCAT(?, UserSalt), 256)",array($_POST["email"],$_POST["password"]));

    Response::printResponse(true,$result,DONE);

}catch (Exception $e){
    Response::printResponse(false,null,ERROR_EMAILPASSWORD);

}

