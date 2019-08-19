<?php
/**
 * Created by PhpStorm.
 * User: Sipio
 * Date: 08/03/2019
 * Time: 11:19
 */



class SipioToken{

    public static function createToken($idUtente){

        $rand="";

        $seed = str_split('abcdefghijklmnopqrstuvwxyz'

            .'ABCDEFGHIJKLMNOPQRSTUVWXYZ'

            .'0123456789!@#$%^&*()[]{}_'
        ); // and any other characters

        shuffle($seed); // probably optional since array_is randomized; this may be redundant



        for($i=0;$i<150;$i++){

            $rand .= $seed[rand(0,count($seed)-1)];

            if($i==100){

                $rand.=microtime();

            }

        }



        $codiceCorrettivo=rand(0,10000000);


        return strrev(SipioToken::converttochar($codiceCorrettivo))."_".$rand."S".(SipioToken::converttochar($idUtente+$codiceCorrettivo));

    }





    public static  function createConfirmCode(){

        $rand="";



        $seed = str_split('abcdefghijklmnopqrstuvwxyz'

            .'ABCDEFGHIJKLMNOPQRSTUVWXYZ'

            .'0123456789'); // and any other characters

        shuffle($seed); // probably optional since array_is randomized; this may be redundant



        for($i=0;$i<99;$i++){

            $rand .= $seed[rand(0,count($seed)-1)];

            if($i==100){

                $rand.=microtime();

            }

        }

        return $rand;



    }











    public static function extractIdUtente($tokena){

        $idUserSub="";

        $idUsermask="";



        $token= str_split($tokena);









        for($i=0;$i<count($token);$i++){



            if($token[$i]=='_'){

                break;

            }



            $idUserSub=$idUserSub.$token[$i];



        }







        for($i=count($token);$i>0;$i--){



            if($token[$i]=='S'){

                break;

            }



            $idUsermask=$idUsermask.$token[$i];



        }





        $idUser=intval(strrev(SipioToken::converttonumber($idUsermask)))-intval(strrev(SipioToken::converttonumber($idUserSub)));

        return $idUser;

    }



    private static  function converttochar($codiceCorrettiv){

        $codiceCorrettivo=str_split($codiceCorrettiv);



        for($i=0;$i<count($codiceCorrettivo);$i++){

            $codiceCorrettivo[$i]=chr($codiceCorrettivo[$i]+65);



        }

        $codiceCorrettivo=implode("",$codiceCorrettivo);

        return($codiceCorrettivo);

    }



    private static function converttonumber($codiceCorrettiv){



        //print "<br>".$codiceCorrettiv;

        $codiceCorrettivo=str_split($codiceCorrettiv);



        for($i=0;$i<count($codiceCorrettivo);$i++){

            $codiceCorrettivo[$i]=ord($codiceCorrettivo[$i])-65;



        }

        $codiceCorrettivo=implode("",$codiceCorrettivo);

        //print "<br>".$codiceCorrettivo;

        return($codiceCorrettivo);

    }











    public static function checkPassword($pwd) {



        if (strlen($pwd) < 8) {

            return false;

        }



        if (!preg_match("#[0-9]+#", $pwd)) {

            return false;

        }



        if (!preg_match("#[a-zA-Z]+#", $pwd)) {

            return false;

        }



        return true;

    }

}