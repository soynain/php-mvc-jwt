<?php
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/*This class is implemented in a simple way, I can do more responses
based on the exception returned, details*/
class JwtDecoderComponent
{
    public static function decode($jwtToken)
    {
        try {
            $decoded = JWT::decode($jwtToken, new Key(KEY_ENC,"HS256"));
            return $decoded;
        } catch (SignatureInvalidException $e) {
            return null;
        } catch (BeforeValidException $e) {
            return null;
        } catch (ExpiredException $e) {
            return null;
        } catch(Exception $e){
            return null;
        }
    }
}
