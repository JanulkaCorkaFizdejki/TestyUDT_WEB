<?php



$file = array_filter(array_map("trim", file("udt_new.txt")), "strlen");

$num = array("1", "2", "3", "4", "5", "6", "7", "8", "9");

$anssversValues = [
2, 1, 1, 1, 4, 1, 1, 2, 4, 1, 
4, 3, 1, 1, 1, 4, 4, 4, 1, 1, 
4, 4, 2, 2, 1, 1, 4, 4, 2, 1, 
3, 2, 3, 1, 1, 4, 4, 1, 2, 1, 
2, 4, 1, 4, 4, 3, 1, 3, 4, 4,
3, 1, 1, 1, 2, 1, 4, 2, 4, 1,
2, 2, 2, 3, 4, 1, 3, 4, 1, 1,
2, 2, 4, 1, 4, 1, 1, 3, 2, 1,
4, 1, 2, 2, 3, 1, 4, 1, 3, 1,
1, 2, 2, 1, 3, 4, 2, 3, 4, 2,
1, 1, 1, 4, 1, 1, 1, 2, 2, 2,
3, 1, 3, 4, 3, 2, 2, 3, 2, 3,
2, 1, 4];

require_once('class/model/DatabaseConnectManager.php');
$dbManager = new DatabaseConnectManager();

// $update = "UPDATE q_dzwig_towarowo_osobowy SET imageb64 = '0'";
// $dbManager -> addQuesstion($update);

// $i = $dbManager -> selAnsw();
// $it = 0;
// $indexQ = 0;
// foreach ($i as $row) {
//     if ($it == 4) {
//         $it = 0;
//         $indexQ ++;
//        // echo '<div style = "height: 100px"></div>';
//     }
//     if ($it == $anssversValues[$indexQ] - 1) {
        
//         $update = "UPDATE a_dzwig_towarowo_osobowy SET mmm = 1 WHERE id = $row";
//         echo $update . "</br>";
//         $dbManager -> addQuesstion($update);
//     }
//    $it ++;
// }


// $iterator = 0;
// $iteratorAnswer = 1;
// $ansverValIt = 0;
// foreach($file as $line) {
//     $q = $line[0];
//     if (in_array($q, $num)) {
//         // $question = "";
//         // if ($iterator < 10) {
//         //     $question = trim(substr($line, 1));
//         // }

//         // else if ($iterator < 100) {
//         //     $question = trim(substr($line, 2));
//         // }

//         // else {
//         //     $question = trim(substr($line, 3));
//         // }
//         // $insert = "INSERT INTO q_dzwig_towarowo_osobowy VALUES($iterator, '$question', 1, '')";
//         // $dbManager -> addQuesstion($insert);
//         $iterator ++;
//     }

//     else {

//         if ($ansverValIt == 4) {
//             $ansverValIt = 0;
//             $i = $iterator - 1;
//             echo '</br>'. $i;
//             echo "*********************</br></br></br>";
//         }

//         $absv__val = 0;

//         if ($ansverValIt + 1 == $anssversValues[$iterator - 1]) {
//             $absv__val = 1;
//         }

//         $answer = trim(substr($line, 3));
//         $insert = "INSERT INTO a_dzwig_towarowo_osobowy VALUES($iteratorAnswer, '$answer', 0, $iterator)";
//        $dbManager -> addQuesstion($insert);
      
//        echo $insert . "</br></br>";
//        echo "--------------------------------------------------------</br>";
//         $iteratorAnswer ++;
//         $ansverValIt ++;
//     }
//  }

?>