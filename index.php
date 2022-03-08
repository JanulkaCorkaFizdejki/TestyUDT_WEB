<?php 
if (!isset($_SERVER['HTTPS'])) {
    header("Location: https://testyudt.com");
    die();
}

require_once('php_class/ServiceInit.php');
require_once("api/class/model/settings_app.php");
ServiceInit::start();
?>