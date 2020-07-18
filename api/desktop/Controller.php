<?php
require_once("../class/model/settings_app.php");
require_once('../class/model/DatabaseConnectManager.php');

class Controller {
    private $globalSettingsObj      = NULL;

    function __construct () {
        $this -> globalSettingsObj      = new GlobalSettings();
    }

    public function getPost() {
        if (!isset($_POST["api-key"])) {
            echo json_encode(["status" => 0, "error" => "application-key-not-exist"], JSON_PRETTY_PRINT);
            return;
        }

        if (!$_POST["api-key"] == $this -> globalSettingsObj -> getApiKeyValue ()) {
            echo json_encode(["status" => 0, "error" => "invalid-application-key"], JSON_PRETTY_PRINT);
            return;
        }

        if (isset($_POST["insert-mac-addres"])) {
            $macAddressCollection = $_POST["insert-mac-addres"];

            if ($macAddressCollection == "") {
                echo json_encode(["status" => 0, "message" => "empty-post"], JSON_PRETTY_PRINT);
                return;
            }

            $db = new  DatabaseConnectManager();
            $addDB = $db -> addMacAddress ($macAddressCollection);
            unset($db);

            if ($addDB) {
                echo json_encode(["status" => 1, "message" => "add-mac-address"], JSON_PRETTY_PRINT);
                return;
            } else {
                echo json_encode(["status" => 0, "message" => "no-add-mac-address"], JSON_PRETTY_PRINT);
                return;
            }
            
        } else if (isset($_POST["send-email"])) {
            $emailAddress = $_POST["send-email"];
            if ($emailAddress == "") {
                echo json_encode(["status" => 0, "message" => "empty-email"], JSON_PRETTY_PRINT);
                return;
            }

            if(filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
                $headers = 'Reply-to: no-replay <nnoka.project@gmail.com>'.PHP_EOL;
                $headers .= 'From: Testy UDT<nnoka.project@gmail.com>'.PHP_EOL;
                $headers .= "MIME-Version: 1.0".PHP_EOL;
                $headers .= "Content-type: text/html; charset=utf-8".PHP_EOL; 

                $content = "<h2>Potwierdzenie zakupu aplikacji Testy UDT Desktop</h2>";
                $content .= "<p>Dziękujemy za zakup aplikacji testy UDT</p>";

                $send = mail($emailAddress, "Testy UDT (Desktop) - Potwierdzenie zakupu", $content, $headers);

                if ($send == true) {
                    echo json_encode(["status" => 1, "message" => "send-email"], JSON_PRETTY_PRINT);
                    return;
                } else {
                    echo json_encode(["status" => 0, "message" => "no-send-email"], JSON_PRETTY_PRINT);
                    return;
                }
           } else {
            echo json_encode(["status" => 0, "message" => "invalid-format-email"], JSON_PRETTY_PRINT);
            return;
           }
        } else if (isset($_POST["paynowexternalid"])) {

            if ($_POST["paynowexternalid"] != "show") {
                echo json_encode(["status" => 0, "error" => "Bad requesst"], JSON_PRETTY_PRINT);
            }

            $db = new  DatabaseConnectManager();
            echo json_encode($db -> setAndGetExternalIDPaynow(), JSON_PRETTY_PRINT);
            unset($db);
            return;
        }
    }
}

?>