<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 12/07/2019
 * Time: 11:14
 */


include_once ("../autoload.php");

$ourObjects=array();

if(!isset($_GET["q"])||$_GET["q"]==""){
    Response::printResponse(true,null, DONE);
}


if(isset($_GET["lat"])&&isset($_GET["lng"])){

    $ourObjects = Database::execute("SELECT idHotel, HotelName, HotelDesc, HotelStar, HotelLat, HotelLng FROM Hotel WHERE LOCATE(?,LOWER(CONCAT(HotelName, CONCAT(' ',HotelDesc))))>0 order by LOCATE(?,LOWER(CONCAT(HotelName, CONCAT(' ',HotelDesc)))), SQRT(POW(HotelLat-?,2)+POW(HotelLng-?,2)) ASC", array($_GET["q"],$_GET["q"],$_GET["lat"],$_GET["lng"]));

}else{

    $ourObjects = Database::execute("SELECT idHotel, HotelName, HotelDesc, HotelStar, HotelLat, HotelLng FROM Hotel WHERE LOCATE(?,LOWER(CONCAT(HotelName, CONCAT(' ',HotelDesc))))>0 order by LOCATE(?,LOWER(CONCAT(HotelName, CONCAT(' ',HotelDesc))))", array($_GET["q"],$_GET["q"]));

}

foreach (explode(" ",$_GET["q"]) as $gino){

    if(isset($_GET["lat"])&&isset($_GET["lng"])){
        $toc = Database::execute("SELECT idHotel, HotelName, HotelDesc, HotelStar, HotelLat, HotelLng FROM Hotel WHERE LOCATE(?,LOWER(CONCAT(HotelName, CONCAT(' ',HotelDesc))))>0 order by LOCATE(?,LOWER(CONCAT(HotelName, CONCAT(' ',HotelDesc)))), SQRT(POW(HotelLat-?,2)+POW(HotelLng-?,2)) ASC", array($gino,$gino,$_GET["lat"],$_GET["lng"]));
    }else{
        $toc=Database::execute("SELECT idHotel, HotelName, HotelDesc, HotelStar, HotelLat, HotelLng FROM Hotel WHERE LOCATE(?,LOWER(CONCAT(HotelName, CONCAT(' ',HotelDesc))))>0 order by LOCATE(?,LOWER(CONCAT(HotelName, CONCAT(' ',HotelDesc))))", array($gino,$gino));
    }
    foreach ($toc as $to){
        $check=true;
        foreach ($ourObjects as $ou){
            if($to["idHotel"]==$ou["idHotel"]){
                $check=false;
            }
        }
        if($check){
            array_push($ourObjects, $to);
        }
    }

}

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.openrouteservice.org/geocode/autocomplete?api_key=5b3ce3597851110001cf624886b523364ebe4940a6ad79a880802174&text=".urlencode($_GET["q"])."&focus.point.lon=".$_GET["lng"]."&focus.point.lat=".$_GET["lat"]."&sources=openstreetmap,openaddresses,whosonfirst,geonames&lang=it-IT&size=5");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Accept: application/json, application/geo+json, application/gpx+xml, img/png; charset=utf-8"
));

$response = curl_exec($ch);
curl_close($ch);


Response::printResponse(true, array("assets"=>$ourObjects,"positions"=>json_decode($response,true)["features"]), DONE);














