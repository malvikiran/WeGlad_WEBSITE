<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 27/07/2019
 * Time: 10:31
 */


include_once(__DIR__ . "/../../autoload.php");


$ar=Database::execute(
    "SELECT
   R.idRoom, R.RoomName, R.RoomDesc, R.RoomAdult, R.RoomChild,R.RoomAccessible,
   ifnull(
      (SELECT XD.COSTL FROM (
           SELECT
             SUM(SubRoom_PriceCost*(
               IF(SubRoom_PriceEnd<=CONVERT( :end, DATE),
                  SubRoom_PriceEnd,
                  CONVERT( :end, DATE)
               )-IF(SubRoom_PriceStart>=CONVERT( :start, DATE),
                    SubRoom_PriceStart,
                    CONVERT( :start, DATE)
               )
             )) AS COSTL,
             Room_idRoom
           FROM SubRoom_Price
           WHERE SubRoom_PriceStart>=CONVERT( :start, DATE) AND
                 SubRoom_PriceEnd<=CONVERT( :end, DATE) OR
                 CONVERT( :start, DATE) BETWEEN SubRoom_PriceStart AND SubRoom_PriceEnd
                 OR CONVERT( :end, DATE) BETWEEN SubRoom_PriceStart AND SubRoom_PriceEnd
      ) AS XD WHERE XD.Room_idRoom=R.idRoom)
  ,0)
   +(RoomCost)*
    IF(:start IS NOT NULL AND :end IS NOT NULL,
       ((CONVERT( :end, DATE)-CONVERT( :start, DATE))-
        (SELECT SUM((IF(CONVERT( :end, DATE) between SubRoom_PriceStart AND SubRoom_PriceEnd,CONVERT( :end, DATE), (IF(CONVERT( :end, DATE)<SubRoom_PriceStart OR CONVERT( :start, DATE)>SubRoom_PriceEnd,0,SubRoom_PriceEnd)) )-
                     IF(CONVERT( :start, DATE) between SubRoom_PriceStart AND SubRoom_PriceEnd,CONVERT( :start, DATE), IF(CONVERT( :end, DATE)<SubRoom_PriceStart OR CONVERT( :start, DATE)>SubRoom_PriceEnd,0,SubRoom_PriceStart) )))
         FROM SubRoom_Price WHERE Room_idRoom=idRoom)
       ), 1) AS RoomCost,
   if((((SELECT COUNT(SubRoom.idSubRoom) FROM SubRoom WHERE SubRoom.Room_idRoom=R.idRoom))-(
     SELECT COUNT(*) FROM Book AS BIC WHERE ((BIC.BookDateStart>CAST(:start AS DATE)
                                              AND BIC.BookDateEnd<CAST(:end AS DATE)) OR CAST(:start AS DATE) BETWEEN BIC.BookDateStart
                                             AND BIC.BookDateEnd OR CAST(:end AS DATE) BETWEEN BIC.BookDateStart AND BIC.BookDateEnd) AND BIC.Room_idRoom=R.idRoom))>0,(((SELECT COUNT(SubRoom.idSubRoom) FROM SubRoom WHERE SubRoom.Room_idRoom=R.idRoom))-(
     SELECT COUNT(*) FROM Book AS BIC WHERE ((BIC.BookDateStart>CAST(:start AS DATE)
                                              AND BIC.BookDateEnd<CAST(:end AS DATE)) OR CAST(:start AS DATE) BETWEEN BIC.BookDateStart
                                             AND BIC.BookDateEnd OR CAST(:end AS DATE) BETWEEN BIC.BookDateStart AND BIC.BookDateEnd) AND BIC.Room_idRoom=R.idRoom)),0) as N
 FROM Room AS R WHERE Hotel_idHotel= :hotel AND R.RoomAdult>0 GROUP BY R.idRoom ORDER BY RoomCost",
    array(":start"=>$_POST["start"],":end"=>$_POST["end"],":hotel"=>$_POST["idHotel"]), true);


Response::printResponse(true, $ar,DONE);

