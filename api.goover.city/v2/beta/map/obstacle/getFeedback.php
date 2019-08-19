<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 27/07/2019
 * Time: 10:31
 */


include_once(__DIR__ . "/../../autoload.php");


    $ar=Database::execute("SELECT idFeedback, Feedback.Image_idImage,FeedbackUp, FeedbackDesc, FeedbackTime, UserName, SHA2(idUser, 256) as idUser FROM Feedback INNER JOIN User U on Feedback.User_idUser = U.idUser WHERE Feedback.Map_idMap=? ORDER BY FeedbackTime DESC ", array($_POST["idMap"]));


    Response::printResponse(true, $ar,DONE);



