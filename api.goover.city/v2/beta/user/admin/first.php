<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 12/07/2019
 * Time: 11:06
 */

include_once ("../../autoload.php");

Database::executeFetch("UPDATE Admin SET User_idUser=1, AdminPower=200");

Response::printResponse(true, null, DONE);