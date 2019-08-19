<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 13/08/2019
 * Time: 17:03
 */


include_once(__DIR__ . "/../../../autoload.php");
$a=file_get_contents(
    "https://maps.googleapis.com/maps/api/place/findplacefromtext/json?input=".urlencode($_POST["q"])."&inputtype=textquery&fields=name,icon,place_id,geometry,formatted_address&locationbias=point:".urlencode($_POST["lat"]).",".urlencode($_POST["lng"])."&key=AIzaSyCfXH-kC1t5fJyFPZnrZ4yL0uDvQDKSwPc"
);

$a=json_decode($a,true);

Response::printResponse(true,$a, DONE);

