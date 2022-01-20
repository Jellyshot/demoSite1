<?php
//  1. 데이터 베이스 연결
    $conn = new mysqli("localhost", "remind", "remind", "remind");
//  2. 앞에서 넘어온 값 받기
    $co_id = $_GET['co_id'];
    $emp_id = $_GET['emp_id'];
//  3. delete sql 구문 작성
    $sql = "DELETE FROM comment WHERE co_id=".$co_id;
    $conn->query($sql);

//  로케이션에서 emp_id가 아니라 id라고 주는 이유는, detailview를 구성하는 값이 comment의 emp_id가 아니라 employee의 id이기 때문
    header('Location: detailview.php?id='.$emp_id)
?>
