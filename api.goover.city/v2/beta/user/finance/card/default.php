<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 11/07/2019
 * Time: 22:16
 */

include_once ("../../../autoload.php");

checkInput(array($_POST["token"],$_POST["id"]));

$id=Database::checkUser($_POST["token"]);


try{





    \Stripe\Customer::update(  $id->UserStripe,
        [
            'default_source' => $_POST["id"],
        ]


    );





    Response::printResponse(true, null, DONE);
}catch (Exception $e){
    Response::printResponse(false, $e->getMessage(), ERROR_NOTSPECIFIED);
}
