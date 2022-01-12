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
//파일 업로드 폴더
$upload_path = './uploadfiles/';

if ($chk_login) {

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
    <script defer src="../js/nav.js"></script>
    <header>
      <div class="topnav">
        <div id="myLinks">
          <sapn><a href="../index.php">Home</a></sapn>
          <sapn><a href="../memo/info.php">Memo</a></sapn>
          <span><a href="./boardlist.php">Board</a></span>
          <span><a href="">Blog</a></span>
          <span><a href="">Account</a></span>
        </div>
        <div class="menu_icon">
          <a href="javascript:void(0);" class="icon" onclick="myFunction()">&#9776;</a>
        </div>
      </div>
    </header>
    <h1>My board</h1>
    <br>
    <div class="container">
      <?php
      $id = $_GET['id'];
      $sql = "SELECT * FROM board WHERE id = " . $id;
      // resultset을 가져오기 전에 hits를 적용시켜줘야 view화면에서도 증가된 hit값을 가져온다.
      $hits = "UPDATE board set hits =+ 1 WHERE id=$id ";
      $result = $conn ->query($hits);

      $resultset = $conn->query($sql);
      
      if ($resultset->num_rows >= 0) {
        $row = $resultset->fetch_assoc();
        if (isset($row['uploadfiles'])) {
      
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
      <th>Title</th><td colspan=5 >" . $row['title'] . "</td></tr>
      <tr class=c_tr><th>Contents</th>
      <td colspan=5><p><img src='".$upload_path.$row['uploadfiles']."' alt='No Image in this Record.' width='200px' height='auto'></p><br>" . $row['contents'] . "</td></tr></tbody>";
        echo "</table>";
      }else {
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
      <th>Title</th><td colspan=5 >" . $row['title'] . "</td></tr>
      <tr class=c_tr><th>Contents</th>
      <td colspan=5>" . $row['contents'] . "</td></tr></tbody>";
        echo "</table>";
      }
      ?>
    </div>
    <br>
    <div class="buttons">
      <?php
      echo "<a href='update.php?id=" . $row['id'] . "'><button>수정</button></a><
      a href='deleteprocess.php?id=" . $row['id'] . "'><button>삭제</button></>";
      ?>
      <a href="/board/boardlist.php"><button>뒤로</button></a>
    </div>
    <!-- 여기부터 코멘트 Create 부분!! -->
    <div class="commentform">
    <form action="comment_write.php" method="POST">
        <input type="hidden" name="board_id" value="<?= $id ?>">
        <table>
            <tr><th>Username</th>
            <th><input type="text" name="username" value="<?= 'UserName : ' . $_SESSION['username'] ?>" readonly></th></tr>
            <tr><td>Contents</td><td><input type="text" name="co_contents" placeholder="Comments..."></td></tr>
        </table>
        <input type="submit" value="Save">
    </form>
    </div>
    <!-- 여기부터 코멘트 Read 부분! -->
<?php
    $stmt = "SELECT * b_comments WHERE board_id =".$id;
    $co_result = $conn->query($stmt);

    //하나만 나오면 if문을 while문으로 바꾸어보자.
    //while($row = $co_result->fetch_assoc()){}
    if ($co_result->num_rows > 0) {
      $row = $co_result->fetch_assoc($co_result);
?>
    <div class="commentsview">
      <table>
      <tr><th>UserName</th><th><?= $row['username'] ?></th>
      <td>Update Time</td><td><?= $row['co_uptime'] ?></td></tr>
      <tr><th><?= $row['co_contents'] ?></th></tr>
      </table>  
      <a href="../comment/comment_update.php">수정</a>
      <a href="../comment/co_deleteprocess.php">삭제</a>
    </div>
<?php   
}
?>
  </body>
<?php
}
} else {
  echo outmsg(LOGIN_NEED);
  echo "<a href='../index.php'>인덱스페이지로</a>";
}
?>

  </html>