<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 13/07/2019
 * Time: 00:36
 */


include_once ("../../../../autoload.php");


$output=Database::execute("SELECT idCategory, CategoryName FROM Category");

Response::printResponse(true, $output, DONE);