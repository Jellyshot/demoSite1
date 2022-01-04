<!-- 
  파일명 : oo_user_update.php
  최초작업자 : swcodingschool
  최초작성일자 : 2021-12-29
  업데이트일자 : 2021-12-29
  
  기능: 
  상세정보확인화면에서 수정을 클릭하였을 때 진행되는 코드
  전 단계에서 전달되 id 를 이용, 값을 수정한다. 
-->
<?php
// 연결 준비
require '../util/dbconfig.php';


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

// 수정할 레코드의 id값을 받아온다.
$id = $_GET['id'];
// 해당 id로 데이터를 검색하는 질의문 구성
$sql = "SELECT * FROM notepad WHERE id = " . $id;
// 해당 질의문 실행하여 결과 가져오기
$result = $conn->query($sql);
// 결과셋을 한 개의 행으로 처리하고,
// 필요로 하는 각 컬럼의 값을 얻어온다.

$row = $result->fetch_array();
$username = $row['username'];
$title =  $row['title'];
$description = $row['memo'];
$wrtime = $row['wrtime'];
$uptime = $row['uptime'];

// echo outmsg($description);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/update.css">
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
  <h1>Memo Update</h1>

  <form action="updateprocess.php" method="POST">
    <div class="date">
      <?php
      $currdt = date("Y-m-d h:i:s");
      echo "Update date: " . $currdt;
      ?>
    </div>
    <br>
    <div class="contents">
      <input class="hiddenId" type="hidden" name="id" value="<?= $id ?>" />
      <div class="section">
      <label for="username">Name : </label>
      <input type="text" name="username" value="<?= $username ?>" readonly></div>
      <hr>
      <div class="section">
      <label for="title">Title : </label>
      <input type="text" name="title" value="<?= $title ?>" /></div>
      <hr>
      <div class="memosection">
      <p><label for="description">memo </label><br>
      <textarea name="description" cols="94" rows="15"><?= $description ?></textarea></p></div>
      <!-- <label>uptime</label><?= $uptime ?><br> -->
    </div>
    <div class="buttons">
      <span><input type="submit" value="Save" style="font-size: 16px;" /></span>
      <span><input type="reset" value="Reset" style="font-size: 16px;" /></span>
      <span><input type="button" value="List" style="font-size: 16px;" onclick="history.back(-1);" /></span>
    </div>
  </form>
  <a href="memolist.php"><button>List</button></a>
</body>

</html>