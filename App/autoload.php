<?php
require_once __DIR__."/auth/JWTEncode.php";
require_once __DIR__."/auth/JWTDecode.php";
require_once __DIR__."/Repositories/DatabaseConnection.php";
require_once __DIR__."/Middlewares/AuthMiddlewareJwt.php";
require_once __DIR__."/../vendor/autoload.php";
require_once __DIR__."/config.php";
require_once __DIR__."/DTOs/ResponseDto.php";
require_once __DIR__."/Repositories/Orm.php";
require_once __DIR__."/router.php";
?>