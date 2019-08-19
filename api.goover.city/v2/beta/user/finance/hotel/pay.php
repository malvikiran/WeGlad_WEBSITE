<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 03/08/2019
 * Time: 14:27
 */



include_once(__DIR__ . "/../../../autoload.php");

checkInput(array($_POST["token"],$_POST["costs"],$_POST["dataStart"],$_POST["dataEnd"],$_POST["idHotel"]));


$user=Database::checkUser($_POST["token"]);

$rooms=json_decode($_POST["costs"],true);

$totalRooms=0;

Database::prepareCommit();
foreach ($rooms as $room){

    $totalRooms+=$room["length"];
    for($i=0;$i<$room["length"];$i++) {

        Database::execute(
            "INSERT INTO Book(BookDateStart, BookDateEnd, Room_idRoom, User_idUser, BookStripeCode)
(
  SELECT :start, :end, :idRoom, :idUser, NULL FROM(SELECT
   R.idRoom, R.RoomName, R.RoomDesc,
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
 FROM Room AS R WHERE Hotel_idHotel= :hotel  GROUP BY R.idRoom ORDER BY RoomCost) AS TEMP WHERE TEMP.N-(
    SELECT COUNT(*) FROM Book AS BIC WHERE ((BIC.BookDateStart>CAST(:start AS DATE)
                                     AND BIC.BookDateEnd<CAST(:end AS DATE)) OR CAST(:start AS DATE) BETWEEN BIC.BookDateStart
                                    AND BIC.BookDateEnd OR CAST(:end AS DATE) BETWEEN BIC.BookDateStart AND BIC.BookDateEnd) AND BIC.Room_idRoom=:idRoom)>0 LIMIT 1)",

            array(
                ":start" => $_POST["dataStart"],
                ":end" => $_POST["dataEnd"],
                ":hotel" => $_POST["idHotel"],
                ":idUser" =>$user->idUser,
                ":idRoom" => $room["idRoom"],

            ), true);
    }
}


$res=Database::executeFetch("SELECT COUNT(*) AS RES FROM Book WHERE User_idUser=? AND BookStripeCode IS NULL",array($user->idUser))["RES"];

if($res==$totalRooms){

    $price=0.0;
    foreach ($rooms as $room) {
        $ar = Database::execute(
            "SELECT
   idRoom, RoomName, RoomDesc,
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
      ) AS XD WHERE XD.Room_idRoom=idRoom)
  ,0)
   +(RoomCost)*
    IF(:start IS NOT NULL AND :end IS NOT NULL,
       ((CONVERT( :end, DATE)-CONVERT( :start, DATE))-
        (SELECT SUM((IF(CONVERT( :end, DATE) between SubRoom_PriceStart AND SubRoom_PriceEnd,CONVERT( :end, DATE), (IF(CONVERT( :end, DATE)<SubRoom_PriceStart OR CONVERT( :start, DATE)>SubRoom_PriceEnd,0,SubRoom_PriceEnd)) )-
                     IF(CONVERT( :start, DATE) between SubRoom_PriceStart AND SubRoom_PriceEnd,CONVERT( :start, DATE), IF(CONVERT( :end, DATE)<SubRoom_PriceStart OR CONVERT( :start, DATE)>SubRoom_PriceEnd,0,SubRoom_PriceStart) )))
         FROM SubRoom_Price WHERE Room_idRoom=idRoom)
       ), 1) AS RoomCost,
   if((((SELECT COUNT(SubRoom.idSubRoom) FROM SubRoom WHERE SubRoom.Room_idRoom=Room.idRoom))-(
     SELECT COUNT(*) FROM Book AS BIC WHERE ((BIC.BookDateStart>CAST(:start AS DATE)
                                              AND BIC.BookDateEnd<CAST(:end AS DATE)) OR CAST(:start AS DATE) BETWEEN BIC.BookDateStart
                                             AND BIC.BookDateEnd OR CAST(:end AS DATE) BETWEEN BIC.BookDateStart AND BIC.BookDateEnd) AND BIC.Room_idRoom=Room.idRoom))>0,(((SELECT COUNT(SubRoom.idSubRoom) FROM SubRoom WHERE SubRoom.Room_idRoom=Room.idRoom))-(
     SELECT COUNT(*) FROM Book AS BIC WHERE ((BIC.BookDateStart>CAST(:start AS DATE)
                                              AND BIC.BookDateEnd<CAST(:end AS DATE)) OR CAST(:start AS DATE) BETWEEN BIC.BookDateStart
                                             AND BIC.BookDateEnd OR CAST(:end AS DATE) BETWEEN BIC.BookDateStart AND BIC.BookDateEnd) AND BIC.Room_idRoom=Room.idRoom)),0) as N
 FROM Room WHERE Hotel_idHotel= :hotel  GROUP BY idRoom ORDER BY RoomCost",
            array(":start" => $_POST["dataStart"], ":end" => $_POST["dataEnd"],
                ":idRoom" => $room["idRoom"], ":hotel" => $_POST["idHotel"]), true);

        foreach ($ar as $a){
            $price=$price+(doubleval($a["RoomCost"])*doubleval($room["length"]));
        }
    }


    $charge = \Stripe\Charge::create([
        'amount' => intval(($price<2.0?2.0:$price)*100),
        'currency' => 'eur',
        'customer' => $user->UserStripe,
    ]);


    if($charge->paid){
        Database::execute("UPDATE Book SET BookStripeCode=? WHERE BookStripeCode IS NULL AND User_idUser=?", array($charge->id, $user->idUser));


        Database::doCommit();
        Response::printResponse(true, array("price"=>$price),DONE);
    }else{
        Database::rollBack();
        Response::printResponse(false, array($charge->failure_message),ERROR_NOTSPECIFIED);

    }

}else{
    Database::rollBack();
    Response::printResponse(false, array($res." ".$totalRooms),ERROR_NOTSPECIFIED);
}

