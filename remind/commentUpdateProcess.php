<?php

    // 1. db연결
    $conn = new mysqli("localhost", "remind", "remind", "remind");

    // 2. 받아온 값 변수 저장
    $co_id = $_POST['co_id'];
    $emp_id = $_POST['emp_id'];
    $co_contents = $_POST['co_contents'];
    //echo $co_id."/".$emp_id."/".$co_contents;

    // 3. sql구문 작성 및 실행
    $stmt = $conn->prepare("UPDATE comment SET co_contents = ? WHERE co_id= ?") ;
    $stmt->bind_param("ss", $co_contents, $co_id);
    $stmt->execute();

    // 4. 리소스 반납
    $stmt->close();
    $conn->close();
    echo "수정이 완료되었습니다.";
    // 5. 페이지 이동
    header('Location: detailview.php?id='.$emp_id);
?>