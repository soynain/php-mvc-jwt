<?php
use Firebase\JWT\JWT;
class JwtEncoderClass{
    public static function encodeJwt($payload,$key){
        return JWT::encode($payload, $key, 'HS256');
    }
}
?>