<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 12/07/2019
 * Time: 23:59
 */

include_once ("../../../autoload.php");

checkInput(array($_POST["token"],$_POST["idRoom"]));




$tr=Database::execute("SELECT Image_idImage FROM Room_has_Image WHERE Room_idRoom=? ORDER BY `order` ASC",array($_POST["idRoom"]));





Response::printResponse(true, $tr, DONE);
