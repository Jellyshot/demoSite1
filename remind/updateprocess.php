<?php
    $conn = new mysqli("localhost", "remind", "remind", "remind");
    $id = $_POST['id'];

    // form에서 post방식으로 넘긴 값 변수에 저장
    $emp_phone = $_POST['emp_phone'];
    $emp_deptcode = $_POST['emp_deptcode'];
    $emp_address = $_POST['emp_address'];
    $emp_email = $_POST['emp_email'];

    // update 구문 작성 및 실행. 
    $stmt = $conn->prepare("UPDATE employee SET emp_phone = ?, emp_deptcode = ?, emp_address = ?, emp_email = ? WHERE id = ?");
    $stmt->bind_param("sisss", $emp_phone, $emp_deptcode, $emp_address, $emp_email, $id);
    $stmt->execute();

    // 리소스 반납.0
    $stmt->close();
    $conn->close();

    header('Location: ./detailview.php?id='.$id);
?>