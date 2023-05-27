<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/4_FW_PHP_OO_MVC_jQuery_v2/';
include($path . "model/JWT.class.php");

class middleware{

    public static function decode_token($token){
        $jwt = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/4_FW_PHP_OO_MVC_jQuery_v2/model/credentials.ini',true);
        $secret = $jwt['JWT']['secret'];

        $JWT = new JWT;
        $token_dec = $JWT->decode($token, $secret);
        $rt_token = json_decode($token_dec, TRUE);
        return $rt_token;
    }

    public static function create_token($username){
        $jwt = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/4_FW_PHP_OO_MVC_jQuery_v2/model/credentials.ini',true);
        $header = $jwt['JWT']['header'];
        $secret = $jwt['JWT']['secret'];
        $payload = '{"iat":"' . time() . '","exp":"' . time() + (600) . '","username":"' . $username . '"}';

        $JWT = new JWT;
        $token = $JWT->encode($header, $payload, $secret);
        return $token;
    }


    public static function create_token_refresh($username){
        $jwt = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/4_FW_PHP_OO_MVC_jQuery_v2/model/credentials.ini',true);
        $header = $jwt['JWT']['header'];
        $secret = $jwt['JWT']['secret'];
        $payload = '{"iat":"' . time() . '","exp":"' . time() + (60) . '","username":"' . $username . '"}';

        $JWT = new JWT;
        $token = $JWT->encode($header, $payload, $secret);
        return $token;
    }
}