<?php

require "../util/dbconfig.php";
// 로그인한 상태일 때만 이 페이지 내용을 확인할 수 있다.
require_once '../util/loginchk.php';

if($chk_login){


 $title = $_POST['title'];
 $description = $_POST['description'];
//  $wrtime = $_POST['wrtime'];

 $stmt = $conn->prepare("INSERT INTO notepad(title, memo)VALUES(?, ? )");
 $stmt->bind_param("ss", $title, $description);
 $stmt->execute();

   // 데이터베이스 연결 인터페이스 리소스를 반납한다.
   $conn->close();

   header('Location: ./memolist.php');
   
  }else {
    echo outmsg(LOGIN_NEED);
    echo "<a href='../index.php'>인덱스페이지로</a>";
  }
?>