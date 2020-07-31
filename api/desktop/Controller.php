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
                $headers =  'Reply-to: Testy UDT<contact@testyudt.com>'."\r\n";
                $headers .= 'From: Testy UDT<contact@testyudt.com>'."\r\n";
                $headers .= 'MIME-Version: 1.0'."\r\n";
                $headers .= 'Content-type: text/html; charset=utf-8'."\r\n";
                $headers .= 'X-Mailer: PHP/'.phpversion();


                // $content = '<div style="padding: 20px; font-family: Arial; background-color: #d7ab29; color: #333333">';
                // $content .= '<div><img src="http://testyudt.com/images/testy_udt_logo.png" width = "100" alt="Testy UDT">
                //             <h2>TESTY UDT</h2></div>';
                // $content .= "<h2>Potwierdzenie zakupu aplikacji Testy UDT (Desktop) v 1.0</h2>";
                // $content .= "<p>Dziękujemy za zakup aplikacji testy UDT!</p>";
                // $content .= "</div>";
                $content = '<div class="main-wrapper" style="padding: 20px; font-family: Arial; background-color: #d7ab29; color: #333333; margin: 0">
                <div class="inside-wrapper" style="width: 800px; margin: 0 auto;">
                    <table align="center" border="0" cellpadding="0" role="presentation" style="width: 100%;">
                        <tbody>
                            <tr>
                                <td>
                                    <div style="padding-left: 10px;">
                                        <img src="http://testyudt.com/images/testy_udt_logo.png" width = "80" alt="Testy UDT">
                                    </div>
                                    <h2 style="margin: 0; font-size: 18px;">TESTY UDT</h2>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>
                                        <h2 style="border-top: 4px solid #333333; border-bottom: 4px solid #333333; padding: 10px 0; text-align: center;">Potwierdzenie zakupu aplikacji Testy UDT (Desktop) v 1.0</h2>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="padding: 20px 0;">
                                        <p><b>Dziękujemy za zakup aplikacji Testy UDT!</b></p>
                                        <p style="line-height: 24px;">Aplikacja Testy UDT jest przeznaczona głównie dla osób, które zdobywają kwalifikacje Urzędu Dozoru Technicznego na urządzenia transportu bliskiego. 
                                            Testy teoretyczne udostępnione w aplikacji opracowane są zgodnie z zasadami obowiązującymi na egzaminie teoretycznym Urzędu Dozoru Technicznego.</p>
                                    </div>
                                    <div style="padding: 20px 0;">
                                        <p><b>Wymagania / Specyfikacja</b></p>
                                        <ul style="line-height: 24px;">
                                            <li>Stały dostęp do Internetu</li>
                                            <li>Zainstalowana Java</li>
                                            <li>Opłata jest opłatą jednorazową i dotyczy danego urządzenia</li>
                                        </ul>
                                    </div>
                                    <div style="padding: 20px 0;">
                                        <p style="text-align: center;"><b>Pobierz na urządzenia mobilne</b></p>
                                        <table style="width: 100%;">
                                            <tbody>
                                                <tr>
                                                    <td align="center">iOS (iPhone)</td>
                                                    <td align="center">Android</td>
                                                </tr>
                                                <tr>
                                                    <td align="center"><img src="http://testyudt.com/images/qr_appstore_5.png" alt="QRCODE - App Strore Testy UDT"></td>
                                                    <td align="center"><img src="http://testyudt.com/images/qr_googleplay_5.png" alt="QRCODE - Google Play Testy UDT"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="padding: 40px 0 20px 0; background-color: #333333; color: #ffffff; margin-top: 40px;">
                                        <p style="text-align: center; margin-bottom: 30px;">Jeśli masz pytania, sugestie lub uwagi skontaktuj się z nami:</p>
                                        <table style="width: 60%; margin: 0 auto;">
                                            <tbody>
                                                <tr>
                                                    <td align="center">
                                                        <a href="http://testyudt.com/" 
                                                            style="display: block; 
                                                            background-color: #25ad5f;
                                                            width: 180px;
                                                            font-size: 14px;
                                                            font-weight: bold;
                                                            text-align: center;
                                                            text-decoration: none;
                                                            padding: 10px 0;
                                                            color: #ffffff
                                                            ">
                                                            WWW
                                                        </a>
                                                    </td>
                                                    <td align="center">
                                                        <a href="https://www.facebook.com/TestyUDT" 
                                                            style="display: block; 
                                                            background-color: #4267B2;
                                                            width: 180px;
                                                            font-size: 14px;
                                                            font-weight: bold;
                                                            text-align: center;
                                                            text-decoration: none;
                                                            padding: 10px 0;
                                                            color: #ffffff
                                                            ">
                                                            Facebook
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <p style="font-size: 10px; text-align: center; margin-top: 60px;">
                                            &copy; Qwerty Media (NNOKA) | 2020
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>';

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