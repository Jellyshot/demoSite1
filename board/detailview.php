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
  <link rel="stylesheet" href="./css/bdetailview.css">
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

    $sql = "SELECT * FROM board WHERE id = " . $id;
    $resultset = $conn->query($sql);

    if ($resultset->num_rows >= 0) {
      $row = $resultset->fetch_assoc();
      echo "<table>
      <thead>
      <tr>
      <th>ID</th><td>" . $row['id'] . "</td>
      <th>USERNAME</th><td>" . $row['username'] . "</td>
      <th>Hits</th><td>" . $row['hits'] . "</td>
      </tr>
      <tr>
      <th>Writing Date</th><td colspan=2 >" . $row['wrtime'] . "</td>
      <th>Last Update</th><td colspan=2 >" . $row['uptime'] . "</td>
      </tr></thead>
      <tbody>
      <tr>
      <th>Title</th><td colspan=5 >" . $row['title']. "</td></tr>
      <tr class=c_tr><th>Contents</th>
      <td colspan=5>" . $row['contents'] . "</td></tr></tbody>";
      echo "</table>";
    }
    ?>
  </div>
  <br>
  <div class="buttons">
    <?php
      echo "<a href='update.php?id=" . $row['id'] . "'><button>수정</button></a><a href='deleteprocess.php?id=" . $row['id'] . "'><button>삭제</button></a>";
    ?>
    <a href="/board/boardlist.php" ><button>
      뒤로</button></a>
  </div>
</body>
<?php 
}else {
  echo outmsg(LOGIN_NEED);
  echo "<a href='../index.php'>인덱스페이지로</a>";
}
?>
</html>