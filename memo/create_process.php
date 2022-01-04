<?php

require "../util/dbconfig.php";

 $title = $_POST['title'];
 $description = $_POST['description'];
//  $wrtime = $_POST['wrtime'];

 $stmt = $conn->prepare("INSERT INTO notepad(title, memo)VALUES(?, ? )");
 $stmt->bind_param("ss", $title, $description);
 $stmt->execute();

   // 데이터베이스 연결 인터페이스 리소스를 반납한다.
   $conn->close();

   header('Location: ./memolist.php');
?>