<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 11/07/2019
 * Time: 21:50
 */


include_once ("../../autoload.php");


checkInput(array($_GET["c"]));



$p=Database::executeFetch("SELECT * FROM User WHERE UserEmailVerify=?", array($_GET["c"]));




if(isset($p)){

    if(!isset($p["UserStripe"])) {
        $customer = \Stripe\Customer::create([
            "email" => $p["UserEmail"],
            "description" => "Simple User",
        ])["id"];
    }else{
        $customer=$p["UserStripe"];
    }
    Database::execute("UPDATE User SET UserStripe=?, UserEmailVerify=NULL WHERE UserEmailVerify=?", array($customer,$_GET["c"]));
    Response::printResponse(true,null,DONE);
}else{
    Response::printResponse(false,null,ERROR_NOTSPECIFIED);
}

