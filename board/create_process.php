<?php

require "../util/dbconfig.php";
$id = $_POST['id'];
$title = $_POST['title'];
$contents = $_POST['contents'];
$username = $_POST['username'];
$stmt = $conn->prepare("INSERT INTO board(title, contents, username)VALUES(?, ?, ? )");
$stmt->bind_param("sss", $title, $contents, $username);
$stmt->execute();

  // 데이터베이스 연결 인터페이스 리소스를 반납한다.
  $conn->close();

  header('Location: ./boardlist.php');
