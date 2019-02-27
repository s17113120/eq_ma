<?php

require_once("../db_connect/db_connect.php");
require_once("../function/global_function.php");


if(!empty($_POST["type"])){
    switch ($_POST["type"]) {

        case 'showData':
            $response = [];
            $result = "SELECT * FROM `device` WHERE `D_Status` = 0";
            $showdate = sqlQry( $result , [] );

            $response['toShowDate'] = $showdate;
            echo json_encode($response);
        break;


        case "searchData":

                $response = [];

                if ($_POST['inputValue'] == "已借出") {
                    $result = "SELECT * FROM `device` WHERE `D_Lend` = ? AND `D_Status` = 0";
                    $searchData = sqlQry( $result , [ 1 ] );
                    $response['toSearchData'] = $searchData;
                } else if ($_POST['inputValue'] == "未借出") {
                    $result = "SELECT * FROM `device` WHERE `D_Lend` = ? AND `D_Status` = 0";
                    $searchData = sqlQry( $result , [ 0 ] );
                    $response['toSearchData'] = $searchData;
                } else {
                    $searchvalue = '%' . $_POST['inputValue'] . '%';
                    $result = "SELECT * FROM `device` WHERE
                    `D_Status` = 0 AND
                    `D_Id` LIKE ? OR
                    `D_Status` = 0 AND
                    `D_Number` LIKE ? OR
                    `D_Status` = 0 AND
                    `D_Name` LIKE ? OR
                    `D_Status` = 0 AND
                    `D_Model` LIKE ? OR
                    `D_Status` = 0 AND
                    `D_Day` LIKE ? OR
                    `D_Status` = 0 AND
                    `D_Unit` LIKE ? OR
                    `D_Status` = 0 AND
                    `D_Details` LIKE ?
                    ";
                    $searchData = sqlQry( $result , [ $searchvalue,$searchvalue,$searchvalue,$searchvalue,$searchvalue,$searchvalue,$searchvalue ] );
                    $response['toSearchData'] = $searchData;
                }

                echo json_encode($response);
            break;

        // case "reset":

        //     $response = [];
        //     $resetAllData = sqlQry("SELECT `D_Id`,`D_Number`,`D_Name`,`D_Model`,`D_Day`,`D_Unit`,`D_Lend` FROM `device`;",[]);

        //     if(!empty($resetAllData)){
        //         $response['status'] = '1';
        //         $response['resetAllData'] = json_encode($resetAllData);
        //     } else {
        //         $response['status'] = '0';
        //     }

        //     echo(json_encode($response));

        // break;
    }

}

?>