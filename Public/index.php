<?php
require_once __DIR__."/../App/config.php";

Router::serveEndpoint($_SERVER["REQUEST_METHOD"],URL);
?>