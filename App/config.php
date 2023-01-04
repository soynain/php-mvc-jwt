<?php
require_once __DIR__."/autoload.php";
//$pathRoute=dirname($_SERVER["SCRIPT_NAME"]);
define("URL",substr($_SERVER["REQUEST_URI"],strlen(dirname($_SERVER["SCRIPT_NAME"]))));
define("KEY_ENC","1234");

DbConnection::init();
?>