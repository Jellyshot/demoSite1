<!-- 
  파일명 : oo_user_loginsuccess.php
  최초작업자 : swcodingschool
  최초작성일자 : 2021-12-28
  업데이트일자 : 2021-12-28
  
  기능: 
  로그인 성공했을 때, success 메시지 간단히 출력하고...
  여기에서는 사용자 목록 리스팅 기능을 수행하도록 구성함.
-->
<?php
// db연결 준비
require "../util/dbconfig.php";

// create connection
// get connection 하는 코드를 adbconfig로 이동하며... 
// 아래 코드는 일단 코멘트 처리함. 2021-12-29 by swcodingschool
//================  여기부터 ============================================
// $conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);

// // check connection : 연결 확인, 오류가 있으면 메시지 출력 후 프로세스 정료
// if($conn->connect_error) {
//   echo outmsg(DBCONN_FAIL);
//   die("연결실패 :".$conn->connect_error);
// }else {
//   if(DBG) echo outmsg(DBCONN_SUCCESS);
// }
//================  여기까지 ============================================
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/memolist.css">
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
  <h1>메모 목록</h1>
  <br>
  <div class="buttons">
    <a href="./create.php"><button>New</button></a>
    <a href="./info.php"><button>Back</button></a>
  </div>
  <br>
  <div class="container">
    <?php
    $sql = "SELECT * FROM notepad";
    $resultset = $conn->query($sql);

    if ($resultset->num_rows >= 0) {
      echo "<table><tr><th>ID</th><th>USERNAME</th><th>Title</th><th>Memo</th><th>Writing date</th><th>Last Update</th></tr>";
      // out data of each row
      while ($row = $resultset->fetch_assoc()) {

        echo "<tr><td>" . $row['id'] . "</td><td>" . $row['username'] . "</td><td>" . $row['title'] . "</td><td><a href='detailview.php?id=" . $row['id'] . "'>" . $row['memo'] . "</a></td><td>" . $row['wrtime'] . "</td><td>" . $row['uptime'] . "</td></tr>";
      }
      echo "</table>";
    }
    ?>
  </div>
</body>

</html>