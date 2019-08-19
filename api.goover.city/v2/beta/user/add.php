<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 11/07/2019
 * Time: 14:51
 */

include_once ("../autoload.php");

checkInput(array($_POST["email"],$_POST["password"],$_POST["name"]));



$salt=uniqid();
$checkEmail=uniqid().uniqid().uniqid();


try{
    Database::execute("INSERT INTO User(UserName,UserEmail,UserEmailVerify,UserPassword,UserSalt) VALUE (?,?,?,SHA2(CONCAT(?, ?), 256),?)",array($_POST["name"],  $_POST["email"],    $checkEmail,  $_POST["password"],$salt,$salt));



    $result= Database::executeFetch("SELECT idUser FROM User WHERE UserEmail=?",array($_POST["email"]));


$tok=SipioToken::createToken($result["idUser"]);
    Database::execute("UPDATE User SET UserToken=? WHERE idUser=?",array($tok,$result["idUser"]));


    sendEmail("WeGlad - Conferma registrazione",$_POST["email"],$_POST["name"],"

<html>

<head>

<title>WeGlad - EMAIL di conferma</title>

</head>

<body>

<center><img src=\"http://goover.city/img/gooverlogo.png\" width='200'>

<br><br>

Ciao ".$_POST["name"].",

<br>

<br>Siamo felici di averti nella nostra community.

<br><br><br>

Anche tu da questo momento puoi sfruttare le potenzialit&#224; 

dell'app ed aiutare i membri della community, 

come loro fanno con te.



<br><br><br><br>

Utilizza l'app che ti consiglia il percorso migliore e ti permette

di trovare i locali accessibili grazie all'aiuto di tutti!

<br><br>

Segnala per aiutare il prossimo, come hanno fatto

tutte le gooverpeople!

<br><br>

<br>

<br>Usa questo link per confermare la tua mail <a href='http://api.goover.city/v2/beta/user/confirm/email.php?c=$checkEmail'>http://api.goover.city/v2/beta/user/confirm/email.php?c=$checkEmail</a>



<br>

A presto,

Il Team WeGlad

</center>

</body>

</html>

");




    Response::printResponse(true,array("token"=>$tok,"UserCode"=>hash('sha256', $result["idUser"])),DONE);
}catch (Exception $exception){

    Response::printResponse(false,null,ERROR_ALREDYREGISTERED);
}
