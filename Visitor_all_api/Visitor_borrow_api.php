<?php

require_once("../db_connect/db_connect.php");
require_once("../function/global_function.php");

if (!empty($_POST["type"])) {
    switch ($_POST["type"]) {
        case "showAllDataTable":
                $response = [];
                $showAllDataTable = sqlQry("SELECT *
                FROM `borrow` JOIN `device` ON `borrow`.`D_Id` = `device`.`D_Id` WHERE `B_Statement_Status` = 0;",[]);
                // $response['showAllDataTableTo'] = json_encode($showAllDataTable);
                $response['showAllDataTable'] = $showAllDataTable;
                echo json_encode($response);
                break;
        case "searchData":

            $havadata = false;

            if ($_POST['inputValue'] == "未審核") {

                $result = "SELECT * FROM `borrow` JOIN `device` ON `borrow`.`D_Id` = `device`.`D_Id` WHERE
                `B_Statement_Status` = ? AND
                `B_Checkoutnumber` = ?
                ";
                $searchdata = sqlQry( $result , [ 0,2 ] );

                $response['tosearchdata'] =  $searchdata;
                $havadata = true;

            } else if ($_POST['inputValue'] == "已審核") {
                $result = "SELECT * FROM `borrow` JOIN `device` ON `borrow`.`D_Id` = `device`.`D_Id` WHERE
                `B_Statement_Status` = ?
                `B_Checkoutnumber` = ?
                ";
                $searchdata = sqlQry( $result , [ 0,1 ] );

                $response['tosearchdata'] =  $searchdata;
                $havadata = true;
            } else {

                $inputvalue = '%' . $_POST['inputValue'] . '%';

                $response = [];
                $result = "SELECT * FROM `borrow` JOIN `device` ON `borrow`.`D_Id` = `device`.`D_Id`
                WHERE `borrow`.`B_Statement_Status` = 0 AND
                `borrow`.`U_Id` LIKE ? OR
                `borrow`.`B_Statement_Status` = 0 AND
                `borrow`.`D_Id` LIKE ? OR
                `borrow`.`B_Statement_Status` = 0 AND
                `device`.`D_Name` LIKE ? OR
                `borrow`.`B_Statement_Status` = 0 AND
                `borrow`.`B_Expected_OutDay` LIKE ? OR
                `borrow`.`B_Statement_Status` = 0 AND
                `borrow`.`B_Expected_InDay` LIKE ? OR
                `borrow`.`B_Statement_Status` = 0 AND
                `borrow`.`B_Details` LIKE ?
                ;";
                $searchdata = sqlQry( $result , [ $inputvalue,$inputvalue,$inputvalue,$inputvalue,$inputvalue,$inputvalue ] );

                if ($searchdata) {
                    $response['tosearchdata'] =  $searchdata;
                    $havadata = true;
                } else {
                    $response['tosearchdata'] =  $searchdata;
                }

            }

            $response['havadatatruefalse'] =  $havadata;

            echo json_encode($response);

            break;
        case "add":
            $borrowAddUser = $_POST["borrowAddUser"];
            $borrowAddD_Id = $_POST["borrowAddD_Id"];
            // $borrowAddD_Name = $_POST["borrowAddD_Name"];
            $borrowAddOutDay = $_POST["borrowAddOutDay"];
            $borrowAddInDay = $_POST["borrowAddInDay"];
            $borrowAddDetails = $_POST["borrowAddDetails"];
            $response = [];
            $checktruefalse1 = false;
            $checkidborrowtruefalse = false;

            $checkresult = "SELECT * FROM `device` WHERE `D_Id` = ? AND `D_Lend` = ?";
            $checkidborrow = sqlQry( $checkresult , [ $borrowAddD_Id,1 ] );

            if ($checkidborrow) {
                $checkidborrowtruefalse = true;
                $response['toccheckidborrowtruefalse'] = $checkidborrowtruefalse;
            } else {
                $response['toccheckidborrowtruefalse'] = $checkidborrowtruefalse;

                $result = "INSERT INTO `borrow` (`U_Id`,`D_Id`,`B_Expected_OutDay`,`B_Expected_InDay`,`B_Details`) VALUES (?,?,?,?,?);";
                $allData = sqlEdit($result, [$borrowAddUser, $borrowAddD_Id, $borrowAddOutDay,$borrowAddInDay, $borrowAddDetails]);


                if ($allData) {
                    $checktruefalse1 = true;
                    $response['backDataBase'] = $allData;
                } else {

                }
                $response['checktruefalse'] = $checktruefalse1;
            }


            echo json_encode ($response);
            // print_r ($_POST);

            break;

            case "changepage":
                $nowClickbutton = $_POST["nowClickButton"];

                $allDataBase = sqlQry("SELECT `borrow`.`B_Out_Id`,
                `borrow`.`U_Id`,
                `borrow`.`D_Id`,
                `device`.`D_Name`,
                `borrow`.`B_OutDay`,
                `borrow`.`B_Details`,
                `borrow`.`B_Checkoutnumber`
                FROM `borrow` JOIN `device` ON `borrow`.`D_Id` = `device`.`D_Id`;",[]);

                $response = [];
                $response['allDataBase'] = $allDataBase;
                $response['nowClickbutton'] = $nowClickbutton;
                // echo json_encode($response);
                echo json_encode($response);
            break;

    }

}


?>