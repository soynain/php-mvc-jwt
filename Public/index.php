<?php
require_once __DIR__ . "/../App/config.php";
// you want to allow, and if so:
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization, Bearer-token');
header('Content-Type: application/json');
Router::serveEndpoint($_SERVER["REQUEST_METHOD"], URL);
