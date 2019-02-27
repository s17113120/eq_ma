<?php

    session_start();
    // echo $_SESSION['membername'];
    if ($_SESSION['membername']) {
        // echo ($_SESSION['membername']);
    } else {
        unset($_SESSION["membername"]);
        header("Location: ../index.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <title>MENU</title>
</head>
<style>
    .btn{
        margin:5px;
        width:300px;
        height: 75px;
        border-radius:75px;
        font-size:20px;
    }
    .container{
		display:relative;
		top: 50%;
		position: absolute;
		left: 50%;
		transform: translate(-50%,-50%);
	}

</style>
<body>
    <div class="container" align="center" valign="center">

        <div>
            <table>
                <div>
                    <tr>
                        <div>
                            <td>
                                <a href="../Visitor_page/Visitor_device_page.php"><button type="button" class="btn btn-outline-primary">設備資料</button></a>
                            </td>
                        </div>
                    </tr>
                </div>
                <div>
                    <tr>
                        <div>
                            <td>
                                <a href="../Visitor_page/Visitor_borrow_page.php"><button type="button" class="btn btn-outline-primary">借出資料</button></a>
                            </td>
                        </div>
                    </tr>
                </div>
                <div>
                    <tr>
                        <div>
                            <td>
                                <a href="../index.php?logout=true"><button type="button" class="btn btn-outline-info">Logout</button></a>
                            </td>
                        </div>
                    </tr>
                </div>
            </table>
        </div>

    </div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</body>
</html>