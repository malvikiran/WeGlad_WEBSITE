<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 12/10/2018
 * Time: 12:57
 */



include_once(__DIR__ . "/../autoload.php");
header('Content-Type: text/html; charset=utf-8');


$ax=(json_decode($_GET["coord"]));

$stringToSend=array();



$boundries=array();

foreach ($ax as $a){
    array_push($stringToSend,$a[1].",".$a[0]);
    array_push($boundries, array($a[1], $a[0]));
}

$polygon = new \League\Geotools\Polygon\Polygon($boundries);

$a=array();



$geotools = new \League\Geotools\Geotools();
if($_GET["navigate"]!=1) {
    $bo = Database::execute("SELECT MapLat, MapLng FROM Map WHERE ?<MapLng AND MapLng<? AND ?<MapLat AND MapLat<?", array(
        $polygon->getBoundingBox()->getSouth(),
        $polygon->getBoundingBox()->getNorth(),
        $polygon->getBoundingBox()->getWest(),
        $polygon->getBoundingBox()->getEast(),
    ));



    foreach ($bo as $b){

        $coordinate = new \League\Geotools\Coordinate\Coordinate($b["MapLat"].','.$b["MapLng"]);
        array_push($a, array(createThePolygon($b["MapLat"],$b["MapLng"])));

    }





}


$veichle="cycling-regular";
if($_GET["navigate"]==0){
    $veichle="cycling-regular";
}

if($_GET["navigate"]==1){
    $veichle="driving-car";
}
if($_GET["navigate"]==2){
    $veichle="foot-walking";
}



$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.openrouteservice.org/directions?api_key=".urlencode($ORS_KEY)."&suppress_warnings=true&language=it&coordinates=".urlencode(implode("|",$stringToSend))."&profile=".$veichle."&preference=recommended&geometry_format=polyline&options=".urlencode("{\"avoid_features\":\"\",\"avoid_polygons\":{\"type\":\"MultiPolygon\",\"coordinates\":".json_encode($a)."}}"));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Accept: application/json, application/geo+json, application/gpx+xml, img/png; charset=utf-8"
));

$response = curl_exec($ch);
curl_close($ch);



    Response::printResponse(true,json_decode($response),DONE);


function createThePolygon($lat,$lng){

    return array(
        array(doubleval($lng)-0.0001,doubleval($lat)-0.0001),
        array(doubleval($lng)-0.0001,doubleval($lat)+0.0001),
        array(doubleval($lng)+0.0001,doubleval($lat)+0.0001),
        array(doubleval($lng)+0.0001,doubleval($lat)-0.0001),
        array(doubleval($lng)-0.0001,doubleval($lat)-0.0001));


}


/*array(
        array(doubleval($lat)-0.0001,doubleval($lng)-0.0001),
        array(doubleval($lat)+0.0001,doubleval($lng)-0.0001),
        array(doubleval($lat)+0.0001,doubleval($lng)+0.0001),
        array(doubleval($lat)-0.0001,doubleval($lng)+0.0001),
        array(doubleval($lat)-0.0001,doubleval($lng)-0.0001));*/