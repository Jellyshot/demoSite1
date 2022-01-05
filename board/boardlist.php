<?php
// db연결 준비
require "../util/dbconfig.php";
?>
<!-- 리스트 작성 시작. -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/boardlist.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <title>Document</title>
</head>

<body>
    <header>
        <div class="menu_icon">
            <sapn>&#9776;</sapn>
        </div>
    </header>
    <h1>게시물 목록</h1>
    <br>
    <div class="buttons">
        <a href="./create.php"><button>New</button></a>
        <a href="./info.php"><button>Back</button></a>
    </div>
    <br>
    <div class="container">
        <?php
        $sql = "SELECT * FROM board";
        $resultset = $conn->query($sql);
        
        // 문자열 자르기
        // $title=$board["title"]; 
        // $title = "SELECT title FROM board;";
        // if(strlen($title)>30){
        //     $title = str_replace($title, mb_substr($title,0,30,"utf-8")."···", $title);
        // 
        
        if ($resultset->num_rows >= 0) {
            echo "<table>
            <tr><th>ID</th><th>UserName</th><th>Title</th><th>Writing Date</th><th>Last Update</th><th>Hits</th></tr>";
            // out data of each row
            while ($row = $resultset->fetch_assoc()) {
                echo "<tr><td>" . $row['id'] . "</td><td>" . $row['username'] . "</td><td><a href='detailview.php?id=" . $row['id'] . "'>" . (mb_substr($row['title'],0,20,"utf-8")) . "</a></td><td>" . $row['wrtime'] . "</td><td>" . $row['uptime'] . "</td><td>" . $row['hits'] . "</td></tr>";
            }
            echo "</table>";
        }
        ?>
    </div>
</body>
</html>