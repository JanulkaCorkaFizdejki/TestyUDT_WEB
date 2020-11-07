<?php

const VERSION = 10000;

if (isset($_GET["version"])) {
    $version = $_GET["version"];
    if ($version != "") {
        if (strlen($version) == strlen(VERSION)) {
            try {
                if (! @include('class/model/settings_app.php')) {
                    throw new Exception("Error Processing Request");
                }
                else if(! @include('class/model/DatabaseConnectManager.php')) {
                    throw new Exception("Error Processing Request");
                }
                else {
                    require_once('class/model/settings_app.php');
                    require_once('class/model/DatabaseConnectManager.php');

                    $settings = new TestsList();
                    $testList = $settings -> getTests();

                    $dbManager = new DatabaseConnectManager();

                    $arrayObjects = [];
                    foreach($testList as $key => $value) {
                        $answerRows = $dbManager -> getTableCountRow("a_$key");
                        $questionRows = $dbManager -> getTableCountRow("q_$key");

                        if (!$answerRows or !$questionRows) {
                            header("HTTP/1.1 404 Not Found");
                            break;
                        }

                        $object = (object) [
                            'name' => $key,
                            'questions' => (int) $questionRows,
                            'answers' => (int) $answerRows
                        ];
                        array_push($arrayObjects, $object);
                    }
                    $jsonObject = (object) [
                        'version' => VERSION,
                        'details' => $arrayObjects
                    ];
                    header("HTTP/1.1 200 Ok");
                    header('Content-Type: application/json');
                    echo json_encode($jsonObject, JSON_PRETTY_PRINT);
                }
            } catch (Exception $e) { header("HTTP/1.1 404 Not Found");}
        } else {
            header("HTTP/1.1 401 Unauthorized");
        }
    } else {
        header("HTTP/1.1 401 Unauthorized");
    }
} else {
    header("HTTP/1.1 401 Unauthorized");
}

?>