<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 14/08/2019
 * Time: 12:59
 */



include_once(__DIR__ . "/../../../autoload.php");


$a=Database::execute("SELECT * FROM SubRoom WHERE Room_idRoom=? AND idSubRoom NOT IN(SELECT SubRoom_idSubRoom FROM Book 
                            WHERE ( CAST(? AS DATE) BETWEEN BookDateStart AND BookDateEnd OR 
                            CAST(? AS DATE) BETWEEN BookDateStart AND BookDateEnd OR
                            (CAST(? AS DATE)<BookDateStart AND CAST(? AS DATE)>BookDateEnd) )      AND SubRoom_idSubRoom IS NOT NULL AND
                            SubRoom_idSubRoom NOT IN (SELECT b.SubRoom_idSubRoom FROM Book as b WHERE b.idBook=?)                 
                            )", array($_POST["idRoom"],$_POST["dateStart"],$_POST["dateEnd"],$_POST["dateStart"],$_POST["dateEnd"],$_POST["idBook"]));



Response::printResponse(true, $a,DONE);
