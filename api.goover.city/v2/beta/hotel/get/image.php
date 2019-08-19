<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 12/07/2019
 * Time: 23:59
 */

include_once ("../../autoload.php");

checkInput(array($_POST["token"],$_POST["idHotel"]));




$tr=Database::execute("SELECT Image_idImage FROM Hotel_has_Image WHERE Hotel_idHotel=? ORDER BY `order` ASC",array($_POST["idHotel"]));





Response::printResponse(true, $tr, DONE);
