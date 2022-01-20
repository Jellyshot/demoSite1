<?php
    //1. 데이터 베이스 연결
    $conn = new mysqli('localhost', 'remind', 'remind', 'remind');
    // $sql = " use remind ";

        //데이터 베이스 연결에 문제가 발생했을때 프로그램 정지 시키기.
        if ($conn->connect_error) {
        die("데이터베이스 연결에 문제가 있습니다.").$conn->connect_error;
        }

    //2. form값에서 post방식으로 넘어온 값 변수 설정
    $co_writer = $_POST["co_writer"];
    $emp_id = $_POST["emp_id"];
    $co_contents = $_POST["co_contents"];

    //3. update 쿼리 구문 작성 및 실행
    $sql = $conn->prepare("INSERT INTO comment (emp_id, co_writer, co_contents) VALUES (?, ?, ?)") ;
    $sql->bind_param("sss", $emp_id, $co_writer, $co_contents);
    $sql->execute();

    //4. 리소스 반납
    $sql->close();
    $conn->close();

    //5. 화면 이동
    header('Location: detailview.php?id='.$emp_id);
?>