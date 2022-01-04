<!-- 
  파일명 : oo_user_detailview.php
  최초작업자 : swcodingschool
  최초작성일자 : 2021-12-28
  업데이트일자 : 2022-01-04
  
  기능: 
  id를 GET방식으로 넘겨받아, 해당 id 레코드 정보를 검색,
  화면에 상세 정보를 뿌려준다.
-->
<?php
// db연결 준비
require "../util/dbconfig.php";

// 로그인한 상태일 때만 이 페이지 내용을 확인할 수 있다.
require_once '../util/loginchk.php';

if($chk_login){


// create connection

//================  여기부터 ============================================
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/detailview.css">
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
  <h1>My board</h1>
  <br>
  <div class="container">
    <?php

    $id = $_GET['id'];

    $sql = "SELECT * FROM notepad WHERE id = " . $id;
    $resultset = $conn->query($sql);

    if ($resultset->num_rows > 0) {
      echo "<table><tr><th>ID</th><th>USERNAME</th><th>Title</th><th>Memo</th><th>Writing Date</th><th>Last Update</th><th>수정</th><th>삭제</th></tr>";

      $row = $resultset->fetch_assoc();
      echo "<tr><td>" . $row['id'] . "</td><td>" . $row['username'] . "</td><td>" . $row['title'] . "</td><td>" . $row['memo'] . "</td><td>" . $row['wrtime'] . "</td><td>" . $row['uptime'] . "</td><td><a href='update.php?id=" . $row['id'] . "'><button>수정</button></a></td><td><a href='deleteprocess.php?id=" . $row['id'] . "'><button>삭제</button></a></td></tr>";
      echo "</table>";
    }

    ?>
  </div>
  <br>
  <div class="buttons">
    <a href="boardlist.php" style="font-size: 20px;">
      <i>< Back</i></a>
  </div>
</body>
<?php 
}else {
  echo outmsg(LOGIN_NEED);
  echo "<a href='../index.php'>인덱스페이지로</a>";
}
?>
</html>