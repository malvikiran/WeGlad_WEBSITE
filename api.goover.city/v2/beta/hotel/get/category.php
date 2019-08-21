<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 13/07/2019
 * Time: 00:46
 */



include_once ("../../autoload.php");
checkInput(array($_POST["idHotel"]));

$output=Database::execute("SELECT idCategory, CategoryName FROM Category WHERE idCategory IN (SELECT Category_idCategory FROM allCategory WHERE Hotel_idHotel=?)", array($_POST["idHotel"]));

for($i=0;$i<sizeof($output);$i++){
    $output[$i]["pics"]=Database::execute("SELECT Image_idImage FROM allCategory WHERE Hotel_idHotel=? AND Category_idCategory=?", array($_POST["idHotel"],$output[$i]["idCategory"]));
}

Response::printResponse(true, $output, DONE);
