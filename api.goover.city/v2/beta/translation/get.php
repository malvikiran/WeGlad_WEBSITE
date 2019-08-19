<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 27/07/2019
 * Time: 11:21
 */


include_once(__DIR__ . "/../autoload.php");


$ar=Database::execute("SELECT * FROM Translation");


Response::printResponse(true, $ar,DONE);