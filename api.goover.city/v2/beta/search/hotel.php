<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 12/07/2019
 * Time: 11:14
 */


include_once ("../autoload.php");

$ourObjects=array();
$ourObjects = Database::execute("
SELECT idHotel, HotelName, HotelDesc, HotelStar, HotelLat, HotelLng, HotelAccessible FROM Hotel WHERE idHotel IN (SELECT Hotel_idHotel FROM Room WHERE RoomChild>=ifnull(:child,1) AND RoomAdult>=ifnull(:adult,1)) AND idHotel IN (
SELECT result.Hotel_idHotel FROM (SELECT
   R.idRoom, R.RoomName, R.RoomDesc, R.RoomAdult, R.RoomChild,R.RoomAccessible, R.Hotel_idHotel,
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
 FROM Room AS R WHERE R.RoomAdult>0 GROUP BY R.idRoom ORDER BY RoomCost) AS result WHERE result.N>0) order by SQRT(POW(HotelLat-:lat,2)+POW(HotelLng-:lng,2)) ASC",
        array(":start"=>$_POST["start"],":end"=>$_POST["end"],":child"=>$_POST["child"],":adult"=>$_POST["adult"],":lat"=>$_POST["lat"],":lng"=>$_POST["lng"]),true);



 Response::printResponse(true, $ourObjects, DONE);














