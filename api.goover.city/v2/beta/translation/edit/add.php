<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 27/07/2019
 * Time: 11:21
 */


include_once(__DIR__ . "/../../autoload.php");


$ara=Database::execute("SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='goover_weglad' AND `TABLE_NAME`='Translation'");

$ar=array();
$or=array();
$res=array();
$trans=json_decode($_POST["allTrans"],true);
for ($i=1; $i<sizeof($ara); $i++){
    array_push($ar, $ara[$i]["COLUMN_NAME"]);
    array_push($or, "?");
    array_push($res, $trans[$ara[$i]["COLUMN_NAME"]]);
}

$ar=Database::execute("INSERT INTO Translation(".implode(", ",$ar).") VALUES (".implode(", ",$or).")", $res);
Response::printResponse(true, $ar,DONE);

