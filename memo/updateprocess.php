<!-- 
  파일명 : oo_user_updateprocess.php
  최초작업자 : swcodingschool
  최초작성일자 : 2021-12-28
  업데이트일자 : 2021-12-28
  
  기능: 
  oo_user_update.php 사용자 정보 수정 화면에서 입력된 값을 받아, 
  users 테이블에 사용자 수정된 데이터를 업데이트 한다.
-->

<?php
  // db연결 준비
  require "../util/dbconfig.php";

  // 데이터베이스 작업 전, 회원정보 수정 화면으로 부터 값을 전달 받고
  $id = $_POST['id'];
  $username = $_POST['username'];
  $title =  $_POST['title'];
  $description = $_POST['description'];
  
  // echo outmsg($title);
  // echo outmsg($description);
  // create connection
  

  // 업데이트 처리를 위한 prepared sql 구성 및 bind
  $stmt = $conn->prepare("UPDATE notepad SET title = ?, memo = ? WHERE id = ?" );
  $stmt->bind_param("ssi", $title, $description, $id);
  $stmt->execute();

  // 데이터베이스 연결 인터페이스 리소스를 반납한다.
  $conn->close();

  // 프로세스 플로우를 인덱스 페이지로 돌려준다.
  header('Location: detailview.php?id='.$id);
?>