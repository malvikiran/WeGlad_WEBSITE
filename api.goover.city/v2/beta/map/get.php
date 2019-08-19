<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 27/07/2019
 * Time: 10:31
 */


include_once(__DIR__ . "/../autoload.php");

$user=new UserClass();
$user->idUser=1;

$user=Database::checkUser($_POST["token"]);

$north=$_POST["north"];
$west=$_POST["west"];
$south=$_POST["south"];
$east=$_POST["east"];



$geotools = new \League\Geotools\Geotools();
$coordA   = new \League\Geotools\Coordinate\Coordinate([$north, $west]);
$coordB   = new \League\Geotools\Coordinate\Coordinate([$south, $east]);
$distance = $geotools->distance()->setFrom($coordA)->setTo($coordB);


if($distance->in('km')->haversine()<4.0||$user->isSuper){
    $notToShow=json_decode($_POST["notToShow"],true);





    $ar=Database::execute("SELECT Map.idMap, idType as Type_idType, ifnull(idType NOT IN (SELECT Type_For_Hotel.Type_idType FROM Type_For_Hotel),1) AS isObstacle, if(COUNT(idType)>0,COUNT(idType),1) AS SizeOfType, User_idUser, MapLat, MapLng, MapOvercome, EXISTS(SELECT * FROM Feedback WHERE Feedback.Map_idMap=Map.idMap AND Feedback.User_idUser=?) as isCommented FROM Map LEFT JOIN Map_has_Type ON Map.idMap=Map_has_Type.idMap WHERE ?<MapLng AND MapLng<? AND ?<MapLat AND MapLat<? GROUP BY Map.idMap UNION (SELECT idHotel, -1,0,0,0, HotelLat, HotelLng, 0, 0 FROM Hotel  WHERE ?<HotelLng AND HotelLng<? AND ?<HotelLat AND HotelLat<? AND HotelStripe IS NOT NULL AND HotelEnabled=1)",array_merge(array($user->idUser,$west,$east,$south,$north),array($west,$east,$south,$north)));


    for($i=0;$i<sizeof($ar);$i++){

            if(in_array($ar[$i]["Type_idType"],$notToShow)){
                array_splice($ar, $i,$i);
            }

    }


    Response::printResponse(true, $ar,DONE);


}else{
    Response::printResponse(true, array(),DONE);

}



