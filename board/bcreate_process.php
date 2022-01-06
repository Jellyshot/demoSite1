
<?php

require "../util/dbconfig.php";

require_once '../util/loginchk.php';

if ($chk_login) {

$id = $_POST['id'];
$title = $_POST['title'];
$contents = $_POST['contents'];
$username = $_SESSION['username'];
$stmt = $conn->prepare("INSERT INTO board(id, title, contents, username)VALUES(?, ?, ?, ?)");
$stmt->bind_param("isss", $id, $title, $contents, $username);
$stmt->execute();

  // 데이터베이스 연결 인터페이스 리소스를 반납한다.
  $conn->close();

  header('Location: ../board/boardlist.php');

} else {
  echo outmsg(LOGIN_NEED);
  echo "<a href='../index.php'>인덱스페이지로</a>";
}
?>
  
