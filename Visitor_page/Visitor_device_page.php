<?php
    session_start();
    require_once("../db_connect/db_connect.php");
    require_once("../function/global_function.php");

    if ($_SESSION['membername']) {
        // echo ($_SESSION['membername']);
    } else {
        unset($_SESSION["membername"]);
        header("Location: ../../../Equipment_management/index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <script src="../js/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="../js/sweetalert2.min.css">
    <title>設備資料</title>
</head>
<style>

    body html{
        width: 100%;
        height: 100%;
    }
    @import url('https://fonts.googleapis.com/css?family=Noto+Sans+TC');
    body {
        font-family: 'Noto Sans TC', serif;
        background-size: cover;
        background-repeat: no-repeat;
        background-image: url("../img/2257f5144eb800c.jpg");
    }

    .no1 {

    }
    .leftmenu {
        width: 100%;
        height: 75px;
        text-align: center;
        background-color: #00b7ff;
        font-size: 20px;
        color: #ffffff;
        font-weight:bolder;
    }
    .visitor_title {
        width: 15px;
        text-align: center;
    }
    /* .table {
        background-color: #ffffff;

    } */
    .allTableData {
        background-color: #ffffff;
        border-radius:10px;
        overflow:hidden;
        border: 1px solid #dee2e6;
    }
    #dataTable > tr > td{
        width: 14%;
        text-align: center;
    }
    .menu{
        float: left;
    }
    .table{
        float: right;
    }
    #header{


    }
    #mid{
        /* background-color: #ff9500; */
        /* text-align:center; */
        width: 100%;
        height: 100%;

    }
    #right{
        /* background-color: #00ddff; */

        width: 70%;
        /* height: 50px; */
        float: right;
    }
    #left{
        /* background-color: #0015ff; */

        /* text-align:center; */
        width: 20%;
        /* height: 50px; */
        float: left;
    }


</style>
<body>
    <div class="container-fluid">
        <div>
                <div class="row" id="header">
                    <div class="col-3">

                    </div>
                    <div class="col-1 mt-5 mb-4">
                        <button type="button" class="btn btn-secondary" id="deviceresetButton"><i class="fas fa-sync-alt"></i></button>
                    </div>
                    <div class="col mt-5 mb-4">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center" id="pageButtonTable">

                            </ul>
                        </nav>
                    </div>
                    <div class="col-2 mt-5 mb-4">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="查詢" id="userSearchInput">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-dark" id="userSearchButton"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

            <div id="mid" class="row">


                    <div id="left" class="col-2">
                        <div class="">
                            <input type="text" class="btn leftmenu mt-5" value="選項" readonly>
                            <button type="button" class="btn btn-outline-primary btn-block btn-lg no1 active">設備資料</button>
                            <a href="../Visitor_page/Visitor_borrow_page.php"><button type="button" class="btn btn-outline-primary btn-block btn-lg no2">借出資料</button></a>
                            <a href="../index.php?logout=true"><button type="button" class="btn btn-outline-info btn-block btn-lg no3">Logout</button></a>
                        </div>
                    </div>

                <div id="right" class="col">
                    <div id="table" class="mr-5">
                        <div class="allTableData">
                            <table class="table" style="width=100%">
                            <thead>
                                <tr>
                                <th class="visitor_title" scope="col">財產編號</th>
                                <th class="visitor_title" scope="col">S/N</th>
                                <th class="visitor_title" scope="col">設備名稱</th>
                                <th class="visitor_title" scope="col">型號</th>
                                <th class="visitor_title" scope="col">增財日</th>
                                <th class="visitor_title" scope="col">保管單位</th>
                                <th class="visitor_title" scope="col">借出狀況</th>
                                </tr>
                            </thead>
                            <tbody id="dataTable">
                                <?php

                                ?>
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>


    <script>
        window.onload = function(){
            showAllData();
        }

        let nowClickPage = 0;

        function showAllData(){
            $.ajax({
                url: '../Visitor_all_api/Visitor_device_api.php',
                method: 'post',
                dataType: 'json',
                data: {
                    type: "showData",
                }
            }).done( res => {

                let showData = res.toShowDate;
                let onePageHowData = 2;
                let howPage = Math.ceil(showData.length / onePageHowData);

                let pageButtomStr = "";
                for(let i=0 ; i<howPage ; i++){
                    pageButtomStr +=
                    `<li class="page-item"><a class="page-link" onclick="pageButtonClcikFun(this.id)" id="${i+1}">${i+1}</a></li>`;
                }
                document.querySelector("#pageButtonTable").innerHTML = pageButtomStr;


                if (showData.length > 0) {
                    let showDataStr = "";

                    for (let i=0 ; i < showData.length ; i++) {
                        showDataStr +=
                        `<tr data-page="${Math.ceil((i+1)/onePageHowData)}">
                            <td>
                                ${showData[i].D_Id}
                            </td>
                            <td>
                                ${showData[i].D_Number}
                            </td>
                            <td>
                                ${showData[i].D_Name}
                            </td>
                            <td>
                                ${showData[i].D_Model}
                            </td>
                            <td>
                                ${showData[i].D_Day}
                            </td>
                            <td>
                                ${showData[i].D_Unit}
                            </td>
                            <td>
                                ${(showData[i].D_Lend) == 0 ? `未借出` : `已借出` }
                            </td>
                        </tr>`;
                    }

                    document.querySelector("#dataTable").innerHTML = showDataStr;

                    if (nowClickPage == 0) {
                        pageButtonClcikFun("", 1);
                    } else {
                        pageButtonClcikFun(nowClickPage);
                    }
                } else {
                    document.querySelector("#dataTable").innerHTML = "沒資料";
                }

                console.log(res);
            }).fail( e => {
                console.error(e);
            })
        }

        //pagebuttonclcik
        function pageButtonClcikFun(ob = undefined , page){
            let tr = document.querySelectorAll("tbody > tr");

            if (ob == "" | ob == undefined) {

                for (let i=0 ; i<tr.length ; i++) {
                    tr[i].style.display = 'none';
                    if (tr[i].dataset.page == 1) {
                        tr[i].style.display = '';
                    }

                }

            } else {
                for (let i=0 ; i<tr.length ; i++) {
                    tr[i].style.display = 'none';
                    if (tr[i].dataset.page == ob) {
                        tr[i].style.display = '';
                    }
                }
                nowClickPage = ob;
            }
        }


        // search
        document.querySelector("#userSearchButton").onclick = function () {

            $.ajax({
                url: '../Visitor_all_api/Visitor_device_api.php',
                method: 'post',
                dataType: 'json',
                data:{
                    type: "searchData",
                    inputValue: document.querySelector("#userSearchInput").value,
                }
            }).done( res =>{
                let searchAllData = res.toSearchData;


                let onePageHowData = 2;
                let howPage = Math.ceil(searchAllData.length / onePageHowData);

                let pageButtomStr = "";
                for(let i=0 ; i<howPage ; i++){
                    pageButtomStr +=
                    `<li class="page-item"><a class="page-link" onclick="pageButtonClcikFun(this.id)" id="${i+1}">${i+1}</a></li>`;
                }

                document.querySelector("#pageButtonTable").innerHTML = pageButtomStr;


                if (searchAllData.length > 0) {
                    let searchAllDataStr = "";
                    for (let i=0 ; i < searchAllData.length ; i++) {
                        searchAllDataStr +=
                        `<tr data-page="${Math.ceil((i+1)/onePageHowData)}">
                            <td>
                                ${searchAllData[i].D_Id}
                            </td>
                            <td>
                                ${searchAllData[i].D_Number}
                            </td>
                            <td>
                                ${searchAllData[i].D_Name}
                            </td>
                            <td>
                                ${searchAllData[i].D_Model}
                            </td>
                            <td>
                                ${searchAllData[i].D_Day}
                            </td>
                            <td>
                                ${searchAllData[i].D_Unit}
                            </td>
                            <td>
                                ${(searchAllData[i].D_Lend) == 0 ? `未借出` : `已借出` }
                            </td>
                        </tr>`;
                    }

                    document.querySelector("#dataTable").innerHTML = searchAllDataStr;

                    nowClickPage = 1;

                    if (nowClickPage == 0) {
                        pageButtonClcikFun("", 1);
                    } else {
                        pageButtonClcikFun(nowClickPage);
                    }


                } else {
                    document.querySelector("#dataTable").innerHTML = "沒資料";
                }

                console.log(res);
            }).fail(e =>{
                console.error(e);
            });
        }
        // reset
        document.querySelector("#deviceresetButton").onclick = function () {

            showAllData();
            document.querySelector("#userSearchInput").value = "";

        }

    </script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</body>
</html>