<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 11/07/2019
 * Time: 22:16
 */

include_once ("../../../autoload.php");

checkInput(array($_POST["token"]));

$id=Database::checkUser($_POST["token"]);


try{

    $customer = \Stripe\Customer::retrieve($id->UserStripe);

    $cards = \Stripe\Customer::allSources(
        $id->UserStripe,
        [
            'limit' => 30,
            'object' => 'card',
        ]
    );

    $output=array();

    foreach ($cards["data"] as $card){
        $card = $customer->sources->retrieve($card["id"]);

        array_push($output, array("id"=>$card["id"],"last4"=>$card["last4"],"exp_month"=>$card["exp_month"],"exp_year"=>$card["exp_year"],"brand"=>$card["brand"]));
    }




    Response::printResponse(true, $output, DONE);
}catch (Exception $e){
    Response::printResponse(false, $e->getMessage(), ERROR_NOTSPECIFIED);
}
