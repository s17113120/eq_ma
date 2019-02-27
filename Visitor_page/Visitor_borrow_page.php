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
    @import url('https://fonts.googleapis.com/css?family=Noto+Sans+TC');
    /* .leftbutton{
        width: 100%;
        height: 60px;
    } */
    .no1{

    }
    .leftmenu{
        width: 100%;
        height: 75px;
        text-align: center;
        background-color: #00b7ff;
        font-size: 20px;
        color: #ffffff;
        font-weight:bolder;
    }
    .visitor_title{
        width: 16px;
        text-align: center;
    }
    body {
        font-family: 'Noto Sans TC', serif;
        background-size: cover;
        background-repeat: no-repeat;
        background-image: url("../img/003.jpg");
    }
    .allTableData {
        background-color: #ffffff;
        border-radius:10px;
        overflow:hidden;
        border: 1px solid #dee2e6;
    }
    .addButton {
        border:none;
    }
    #showTable > tr > td{
        width: 16%;
        text-align: center;
    }
    .widthstyle{
        min-width:8rem;
    }
    #left{

        float: left;
    }
    #right{

        float: right;
    }
    #mid{
        width: 100%;
    }
</style>
<body>

<div class="container-fluid">
    <div class="row">
            <div class="col">

            </div>
            <div class="col-3 mt-5 mb-4">
                <button type="button" class="btn btn-secondary" id="deviceResetButton"><i class="fas fa-sync-alt"></i></button>
            </div>
            <div class="col-4 mt-5 mb-4">
                <!-- 分頁 -->
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center" id="pageButton">


                        <!-- <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li> -->

                    </ul>
                </nav>
            </div>
            <div class="col mt-5 mb-3">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="查詢" id="userSearchInput">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-dark" id="userSearchButton"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
    </div>
    <div class="row" id="mid">
        <div id="left" class="col-2">
            <div class="">
                <input type="text" class="btn leftmenu mt-5" value="選項" readonly>
                <a href="../Visitor_page/Visitor_device_page.php"><button type="button" class="btn btn-outline-primary leftbutton btn-block btn-lg no1 ">設備資料</button></a>
                <button type="button" class="btn btn-outline-primary leftbutton btn-block btn-lg no2 active">借出資料</button>
                <a href="../index.php?logout=true"><button type="button" class="btn btn-outline-info leftbutton btn-block btn-lg no3">Logout</button></a>
            </div>
        </div>
        <div id="right" class="col">
            <div class="allTableData right">
                <table class="table" style="width=100%">
                <thead>
                    <tr>
                    <th class="visitor_title" scope="col">
                        <!-- add Button -->
                        <button type="button" class="btn btn-outline-primary addButton" data-toggle="modal" data-target="#addModalCenter">
                            <i class="fas fa-plus">

                            </i>
                        </button>
                    </th>
                    <th class="visitor_title" scope="col">借出使用者</th>
                    <th class="visitor_title" scope="col">借出設備產邊</th>
                    <th class="visitor_title" scope="col">借出設備名稱</th>
                    <th class="visitor_title" scope="col">借出借出日期</th>
                    <th class="visitor_title" scope="col">借出攜入日期</th>
                    <th class="visitor_title" scope="col">備註</th>
                    </tr>
                </thead>
                <tbody id="showTable">

                </tbody>


                </table>

            </div>
        </div>

    </div>


</div>

<!-- add Modal -->
<div class="modal fade" id="addModalCenter" tabindex="-1" role="dialog" aria-labelledby="addModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalCenterTitle">新增借出單</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3 ">
                    <div class="input-group-prepend widthstyle">
                        <span class="input-group-text w-100">借出使用者</span>
                    </div>
                    <input type="text" class="form-control addText" onchange="checkvalue(this)" id="borrowAddUser" placeholder="學號(不用加 s)">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend widthstyle">
                        <span class="input-group-text w-100" >借出設備產邊</span>
                    </div>
                    <input type="text" class="form-control addText" onchange="checkvalue(this)" id="borrowAddD_Id">
                </div>
                <!-- <div class="input-group mb-3">
                    <div class="input-group-prepend widthstyle">
                        <span class="input-group-text w-100" >借出設備名稱</span>
                    </div>
                    <input type="text" class="form-control addText" onchange="checkvalue(this)" id="borrowAddD_Name">
                </div> -->
                <div class="input-group mb-3">
                    <div class="input-group-prepend widthstyle">
                        <span class="input-group-text w-100" >預計借出日期</span>
                    </div>
                    <input type="date" class="form-control addText" onchange="checkvalue(this)" id="borrowAddOutDay">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend widthstyle">
                        <span class="input-group-text w-100" >預計攜入日期</span>
                    </div>
                    <input type="date" class="form-control addText" onchange="checkvalue(this)" id="borrowAddInDay">
                </div>
                <div class="input-group">
                    <div class="input-group-prepend widthstyle">
                        <span class="input-group-text w-100" id="basic-addon1">詳細資料(備註)</span>
                    </div>
                    <textarea class="form-control" aria-label="With textarea" name="borrowAddDetails" id="borrowAddDetails" placeholder="非本實驗室生，要外借基本資料請填這(科系 學號 姓名 聯絡方式)" onchange="checkaddmodelvalue(this)"></textarea>
                    <!-- <div class="input-group-prepend widthstyle">
                        <span class="input-group-text w-100" >備註</span>
                    </div>
                    <textarea class="form-control" onchange="checkvalue(this)" id="borrowAddDetails" placeholder="非本實驗室生，要外借基本資料請填這(科系 學號 姓名 聯絡方式)"> -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="addCloseButton">Close</button>
                <button type="button" class="btn btn-primary" id="addSubmitButton">Save changes</button>
            </div>
        </div>
    </div>
</div>
<script>

window.onload = function(){

    showDataTableFun();


}
let nowClickPage = 1;


// showDataTable
function showDataTableFun() {
    $.ajax({
        url: '../Visitor_all_api/Visitor_borrow_api.php',
        method: 'post',
        dataType: 'json',
        data: {
            type: "showAllDataTable",
        }
    }).done( res =>{

        let allData = res.showAllDataTable;
        let onePageHowData = 2;
        let howPage = Math.ceil(allData.length / onePageHowData);

        let pageButtomStr = "";
        for(let i=0 ; i<howPage ; i++){
            pageButtomStr +=
            `<li class="page-item"><a class="page-link" onclick="pageButtonClcikFun(this.id)" id="${i+1}">${i+1}</a></li>`;
        }
        document.querySelector("#pageButton").innerHTML = pageButtomStr;

        if (allData.length > 0) {
            let showData = "";

            for(let i=0 ; i < allData.length ; i++){

                showData +=
                `<tr style="width:100%" data-id="${allData[i].D_Id}" data-page="${Math.ceil((i+1)/onePageHowData)}">
                    <td>
                        <button class="alert ${(allData[i].B_Checkoutnumber) == 1 ? "alert-primary": "alert-danger"}">${(allData[i].B_Checkoutnumber) == 1 ? "已審核": "未審核"}</button>
                    </td>
                    <td>
                        ${allData[i].U_Id}
                    </td>
                    <td>
                        ${allData[i].D_Id}
                    </td>
                    <td>
                        ${allData[i].D_Name}
                    </td>
                    <td>
                        ${allData[i].B_Expected_OutDay}
                    </td>
                    <td>
                        ${allData[i].B_Expected_InDay}
                    </td>
                    <td>
                        ${allData[i].B_Details}
                    </td>
                </tr>`;
            }

            document.querySelector("#showTable").innerHTML = showData;

            if (nowClickPage == 1) {
                    pageButtonClcikFun("", 1);
            } else {
                pageButtonClcikFun(nowClickPage);
            }


        } else {
            document.querySelector("#showTable").innerHTML = "沒資料";
        }

        console.log(allData);
    }).fail( e =>{
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
        url: '../Visitor_all_api/Visitor_borrow_api.php',
        method: 'post',
        dataType: 'json',
        data:{
            type: "searchData",
            inputValue: document.querySelector("#userSearchInput").value,
        }
    }).done( res => {
        // let havadata = res.havadatatruefalse;

        let searchBackData = res.tosearchdata;

        let onePageHowData = 2;
        let howPage = Math.ceil(searchBackData.length / onePageHowData);

        let pageButtomStr = "";
        for(let i=0 ; i<howPage ; i++){
            pageButtomStr +=
            `<li class="page-item"><a class="page-link" onclick="pageButtonClcikFun(this.id)" id="${i+1}">${i+1}</a></li>`;
        }
        document.querySelector("#pageButton").innerHTML = pageButtomStr;


        if (searchBackData.length > 0) {
            let searchBackDataStr = "";
            for (let i=0 ; i<searchBackData.length ; i++) {
                searchBackDataStr +=
                `<tr data-id="${searchBackData[i].D_Id}" data-page="${Math.ceil((i+1)/onePageHowData)}">
                    <td>
                        <button class="alert ${(searchBackData[i].B_Checkoutnumber) == 1 ? "alert-primary": "alert-danger"}">${(searchBackData[i].B_Checkoutnumber) == 1 ? "已審核": "未審核"}</button>
                    </td>
                    <td>
                        ${searchBackData[i].U_Id}
                    </td>
                    <td>
                        ${searchBackData[i].D_Id}
                    </td>
                    <td>
                        ${searchBackData[i].D_Name}
                    </td>
                    <td>
                        ${searchBackData[i].B_Expected_OutDay}
                    </td>
                    <td>
                        ${searchBackData[i].B_Expected_InDay}
                    </td>
                    <td>
                        ${searchBackData[i].B_Details}
                    </td>
                </tr>`
            }

            document.querySelector("#showTable").innerHTML = searchBackDataStr;

            nowClickPage = 1;

            if (nowClickPage == 1) {
                    pageButtonClcikFun("", 1);
            } else {
                pageButtonClcikFun(nowClickPage);
            }
        } else {
            document.querySelector("#showTable").innerHTML = "查無資料";
        }



        console.log(searchBackData.length);
    }).fail( e => {
        console.log(e);
    });
}

// add
document.querySelector("#addSubmitButton").onclick = function () {
    let addText = document.querySelectorAll(".addText");
    let check = false;
    for(let totalCheck of addText){
        if(totalCheck.value == "" || totalCheck.value == undefined){
            check = true;
        } else {
            check = false;
        }
    }
    if(check){
        alert("紅色方框上未填寫");
    } else {
        $.ajax({
            url: '../Visitor_all_api/Visitor_borrow_api.php',
            method: 'POST',
            dataType: 'json',
            data:{
                type: 'add',
                borrowAddUser: document.querySelector("#borrowAddUser").value,
                borrowAddD_Id: document.querySelector("#borrowAddD_Id").value,
                // borrowAddD_Name: document.querySelector("#borrowAddD_Name").value,
                borrowAddOutDay: document.querySelector("#borrowAddOutDay").value,
                borrowAddInDay: document.querySelector("#borrowAddInDay").value,
                borrowAddDetails: document.querySelector("#borrowAddDetails").value,
            }
        }).done(res => {
                let backDataBase = res.backDataBase;
                let showDataTable = res.reselt1;
                let checkide = res.toccheckidborrowtruefalse;

                if (checkide) {
                    Swal({
                        type: 'error',
                        title: '設備已借出',
                        text: '',
                    })
                } else if(backDataBase){
                    Swal(
                        'Good job!',
                        '已新增借出單，等待人員審核',
                        'success'
                    )
                    document.querySelector("#addCloseButton").click();
                    showDataTableFun();
                } else {
                    Swal({
                        type: 'error',
                        title: '輸入資料錯誤!!!',
                        text: '(沒有使用者或是沒有設備)',
                        // footer: '<a href>Why do I have this issue?</a>'
                    })
                }


            console.log(checkide);
        }).fail(function(e) {



            console.log(e);
        })
    }
    // console.log(addText);
}

// checkvalue
function checkvalue(ob){
    if(ob.value == "" || ob.value == undefined){
        ob.style.borderColor = 'red';
    } else {
        ob.style.borderColor = 'green';
    }
}

// pagebutton

function pagebuttonFunc(){

    $.ajax({
        url: '../Visitor_all_api/Visitor_borrow_api.php',
        method: 'post',
        dataType: 'json',
        data: {
            type: "showAllDataTable",
        }
    }).done( res =>{
        let dataLength = res.showAllDataTable.length;
        let onePageAvgData = dataLength/3;
        let howPageButton = Math.ceil(onePageAvgData);
        let toPageButton = "";
        for(let i=1 ; i <= howPageButton ; i++){
            toPageButton +=
            `<button class="page-link clickbutton" value="${i}" onclick="pageButton(this)">${i}</button>`;
        }
        document.querySelector("#pageButton").innerHTML = toPageButton;
        console.log(toPageButton);
    }).fail( e =>{
        console.error(e);
    })

}

// clickbutton
function pageButton(ob) {

    $.ajax({
        url: '../Visitor_all_api/Visitor_borrow_api.php',
        method: 'post',
        dataType: 'json',
        data: {
            type: "changepage",
            nowClickButton: ob.value,
        }
    }).done( res =>{
        let nowChaagePage = res.nowClickbutton;
        let backAllDataBase = res.allDataBase;
        let dataLength = backAllDataBase.length;
        let showData = "";
        let onePageHowData = 2;//一頁幾個資料 pagebuttonFunc也要改

        let aa = document.querySelectorAll(`[data-page=${nowChaagePage}]`);
        // for (let item of document.querySelectorAll("[data-d_id]")){

        //         console.log(res);
        //         // console.log(document.querySelector("[data-d_id='"+nowChaagePage+"']"));

        // }



        // document.querySelector("#showTable").innerHTML = showData;

        console.log(aa);

    }).fail( e =>{
        console.error(e);
    })


}
document.querySelector("#deviceResetButton").onclick = function () {
    document.querySelector("#userSearchInput").value = "";
    showDataTableFun();
}


</script>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</body>
</html>