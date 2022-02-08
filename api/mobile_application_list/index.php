<?php 
require_once("../class/model/settings_app.php");
require_once("../class/model/GeneratorTestsPool.php");
require_once("../class/model/DatabaseConnectManager.php");

$databaseConnectManager = new DatabaseConnectManager();
$dbReturn = $databaseConnectManager -> getMobileApplicationList();

if ($dbReturn != false) {
    header('Content-type: application/json');
    echo json_encode($dbReturn,  JSON_PRETTY_PRINT);
}
else { header('HTTP/1.0 404 Not Found'); }
?>