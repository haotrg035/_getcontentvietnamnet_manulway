<?php 
require './function.php';
if (!empty($_FILES) && $_FILES['linkfilename']['name']!="") {
    $file = $_FILES["linkfilename"];
    getContentFromListLink($_FILES['linkfilename']['tmp_name']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        #maincontainer{
            width: 70%;
            margin:0 auto;
        }
        input{
            margin: 10px auto; 
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <div id="maincontainer">
        <button><a href="./index.php">Reset</a></button>
        <div>
            <h2>Data hiện có <b><?=count($dataStore) ?></b> dòng.</h2>
        </div>
        <div>
            <h3>Lấy Data từ file danh sách link:</h3>
            <form action="#" method="POST" enctype="multipart/form-data">
                <label for="filenamelink">Đường dẫn file linklist: </label> <br>
                <input type="file" name="linkfilename" id="linkfilename"> <br>
                <input type="submit" value="Lấy Data">
            </form>
            <hr>
        </div>    
        <div>
            <h3><a href="download.php">Lưu file</a></h3>
        </div>  
    </div>
    <?php echo var_dump($dataStore);?>
</body>
</html>