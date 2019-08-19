<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 11/08/2019
 * Time: 19:16
 */


include_once(__DIR__ . "/../../../autoload.php");

$id=Database::checkUser($_POST["token"]);
setcookie("token",$_POST["token"],time()+3600);
setcookie("hotel",$_POST["hotel"],time()+3600);

if(!isset($_GET["code"])){

    header('Location: '."https://dashboard.stripe.com/oauth/authorize?response_type=code&client_id=ca_FbXW7XQI8ZywqINDz5GttWbvHhr1DTN8&scope=read_write&");
}else{


    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://connect.stripe.com/oauth/token');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "client_secret=sk_test_A60Qg4NG4AtrUZybfX2yMpm600Q5KTnI7z&code=".$_POST["code"]."&grant_type=authorization_code");
    curl_setopt($ch, CURLOPT_POST, 1);

    $headers = array();
    $headers[] = 'Content-Type: application/x-www-form-urlencoded';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = json_decode(curl_exec($ch),true);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);

    Database::execute("UPDATE Hotel SET HotelStripe=? WHERE idHotel=?", array($result["stripe_user_id"],$_POST["hotel"]));

    setcookie("isDone","true",time()+3600);
}