<?php 
//require_once("class/model/settings_app.php");

class DatabaseConnectManager {
    private $db_connect         = NULL;
    private $app_settings       = NULL;
    private $db_error_message   = NULL;
    private $json_error         = ["status" => 0, "type" => "error"];

    function __construct() {
        $this -> db_settings = new DatabaseSettings();
        
        try {
            $this -> db_connect = 
            new PDO('mysql:host='.$this -> db_settings -> getDBHost().
            ';dbname='.$this -> db_settings -> getDBName().';port:'.$this -> db_settings -> getDBPort(), 
            $this -> db_settings    -> getDBUser(), 
            $this -> db_settings    -> getDBPassword());
            $this -> db_connect     -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this -> db_connect     -> exec('SET NAMES utf8');
        } catch (PDOException $e) {
            $this -> db_error_message = "Connection failed: " . $e->getMessage();
            $this -> json_error["type"] = $this -> db_error_message;
            echo json_encode($this -> json_error);
        }
    }

    public function getTestPool($query, $answersLimit) {

        $db_data = $this -> db_connect -> query($query);

        $question   = NULL;
        $imageb64   = NULL;
        $answers    = [];
        $values     = [];
        $outputData = [];

        $limiter = 1;
        
        while ($row = $db_data -> fetch()) {
            $limiter = ($limiter > $answersLimit) ? $limiter = 1 : $limiter = $limiter;

            array_push($answers, $row["answers"]);
            array_push($values, $row["values"]);
            
            if ($limiter == 1) {
                $question = $row["question"];
                $imageb64 = $row["imageb64"];
                
            } else if ($limiter == $answersLimit) {
                
                $outputData[] = [
                    "question"  => $question,
                    "answers"   => $answers,
                    "values"    => $values,
                    "imageb64"  => $imageb64
                ];
                $answers    = [];
                $values     = [];
            }

            $limiter++;
        }
        $db_data -> closeCursor();
        return $outputData;
    }

    public function getTestAll($table, $answersLimit = 4) {
        $query = "SELECT `q_".$table."`.`question`, `q_".$table."`.`imageb64`, `a_".$table."`.`answers`, `a_".$table."`.`values` FROM `q_".$table."` INNER JOIN `a_".$table."` ON `q_".$table."`.`id`=`a_".$table."`.`id_questions`";
        return $this -> getTestPool($query,  $answersLimit);
    }

    public function getTableCountRow($tableName) {
            $query = "SELECT COUNT(*) AS rowscount FROM $tableName";
            try {
                $db_data = $this -> db_connect -> query($query);
                $row = $db_data -> fetch();
                return $row['rowscount'];
            } catch (PDOException $e) {
                return false;
            }
    }

    public function getMobileApplicationList ($table = "mobile_application_list") {

        $outputArray = [];

        $query = "SELECT * FROM $table";
            try {
                $db_data = $this -> db_connect -> query($query);
                while ($row = $db_data -> fetch()) {
                    array_push($outputArray, $arrayName = array('id' => $row['id'], 'name' => $row['name'], 'desc_app' => $row['desc_app'], 'imageb64' => $row['imageb64'], 'link' => $row['link']));
                }
                return $outputArray;
            } catch (PDOException $e) {
                return false;
            }
    }

    public function getMacAddress ($macArray) {
        $query = "SELECT COUNT(address) AS isset FROM mac_address WHERE address IN (".implode(', ', $macArray).") LIMIT 1";
        try {
            $db_data = $this -> db_connect -> query($query);
            $row = $db_data -> fetch();
            return array("ok", ($row['isset'] > 0) ? true : false);
        } catch (PDOException $e) {
            return array("error");
        }
    }

    public function addMacAddress ($macAdressString) {
        $mac = explode(",", $macAdressString);

        $outputQuery = "";

        foreach ($mac as $item) {
                $item = trim($item);
                $chunk_query = "('$item', NOW())";
                $outputQuery = $outputQuery.$chunk_query.', ';
        }
        $outputQuery  = substr_replace(trim($outputQuery) ,"",-1);
        $query = 'INSERT INTO mac_address (address, time_add) VALUES '.$outputQuery;

        try {
            $db_data = $this -> db_connect -> query($query);
            return $db_data;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getExternalIDPaynow() {
        $query = "SELECT externalid FROM paynow_externalid LIMIT 1";
        try {
            $db_data = $this -> db_connect -> query($query);
            $row = $db_data -> fetch();
            return array("status" => 1, "paynow-externalID" => $row['externalid']);
        } catch (PDOException $e) {
            return array("status" => 0, "error" => "Database error");
        }
    }

    public function setAndGetExternalIDPaynow() {
        $query = "SELECT * FROM paynow_externalid LIMIT 1";
        try {
            $db_data = $this -> db_connect -> query($query);
            $row = $db_data -> fetch();

            $id = $row['id'];
            $externalID = ++$row['externalid'];

            unset($db_data);
            unset($row);

            $update = 'UPDATE paynow_externalid SET externalid = '.$externalID.' WHERE id = '.$id.'';

            try {
                $stmt = $this -> db_connect -> prepare($update);
                $ex = $stmt -> execute();
                if ($ex) {
                    return array("status" => 1, "paynow-externalID" => $externalID);
                } else {
                    return array("status" => 0, "error" => "Database error");
                }
            } catch (PDOException $e) {
                return array("status" => 0, "error" => $e);
            }
        } catch (PDOException $e) {
            return array("status" => 0, "error" => $e);
        }
    }


    function __destruct() { $this -> db_connect = NULL; }
}
?>