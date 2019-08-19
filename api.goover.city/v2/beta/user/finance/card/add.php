<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 11/07/2019
 * Time: 22:16
 */

include_once ("../../../autoload.php");

checkInput(array($_POST["token"],$_POST["number"],$_POST["exp"],$_POST["cvc"]));

$id=Database::checkUser($_POST["token"]);


try{


    $tokenStripe=\Stripe\Token::create([
        'card' => [
            'number' => $_POST["number"],
            'exp_month' => explode("/",$_POST["exp"])[0],
            'exp_year' => explode("/",$_POST["exp"])[1],
            'cvc' => $_POST["cvc"]
        ]
    ]);


    \Stripe\Customer::createSource(
        $id->UserStripe,
        [
            'source' => $tokenStripe["id"],
        ]
    );


    Response::printResponse(true, null, DONE);
}catch (Exception $e){
    Response::printResponse(false, $e->getMessage(), ERROR_NOTSPECIFIED);
}
