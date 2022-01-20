<?php
    // PHP와 MySQL간의 연결을 설정하는데, 이를 $conn이라고 부르겠다.
    // new mysqli()는 생성자 이기도 함.
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $conn = new mysqli($hostname, $username, $password);

    if (!$conn->connect_error) {
        //my sqli 생성자가 리턴한 값이 null이 아니라면, 연결 설정 성공 메세지를 띄워 연결성공 및 실패를 확인함
        echo "<script>alert('DBMS와 연결이 설정되었습니다.')</script>";
    }else {
        echo "<script>alert('DBMS와 연결을 설정할 수 없습니다. \\n호스트명, 계정, 비밀번호를 확인해 주세요')".$conn->connect_error."</script>";
    }

    // Create DB
    $dbname = "remind";
    //일단 동일한 DB가 있으면 삭제 하고
    $sql = "DROP DATABASE IF EXISTS ".$dbname;
    $conn->query($sql);
    $sql = "CREATE DATABASE IF NOT EXISTS ".$dbname;
    $conn->query($sql);

    // Create user
    // 기존의 account가 있으면 삭제 후 생성
    $account = $dbname;
    $sql = "DROP USER IF EXISTS ".$account;
    $conn->query($sql);
    //사용자 아이디 및 비밀번호 생성
    $sql = "CREATE USER IF NOT EXISTS '".$account."'@'%' IDENTIFIED BY '".$account."'";
    $conn->query($sql);
    //계정의 리소스 제한
    $sql = "GRANT USAGE ON *.* TO '".$account."'@'%' REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTION 0";
    $conn->query($sql);
    //계정에 모든 권한 부여
    $sql = "GRANT ALL PRIVILEGES ON `".$dbname."`.* TO '".$account."'@'%'";
    $conn->query($sql);

    //명시적으로 현재사용 DB 선언
    $sql = "use ". $dbname;
    $conn->query($sql);

    //테이블 생성
    //기존 테이블 있는지 확인 후 
    $sql = "DROP TABLE IF EXISTS 'employee'";
    $conn->query($sql);
    //생성
    $sql = "CREATE TABLE IF NOT EXISTS `".$dbname."`.`employee` (
        `id` INT(8) NOT NULL AUTO_INCREMENT , 
        `emp_name` VARCHAR(50) NOT NULL , 
        `emp_num` VARCHAR(10) NOT NULL , 
        `emp_phone` VARCHAR(13) NULL , 
        `emp_hiredate` DATE NULL DEFAULT CURRENT_TIMESTAMP , 
        `emp_deptcode` INT(6) NULL , 
        `emp_address` VARCHAR(200) NULL , 
        `emp_email` VARCHAR(50) NULL , 
        PRIMARY KEY (`id`)
        ) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci";
    $conn->query($sql);

// 테스트할 table의 recode 반복하여 만들기
    for ($i = 1; $i <= 524; $i++){
        $emp_name = 'test'.$i;
        $emp_num = 'test'.$i;
        $emp_email = $i.'@test.com';
        $emp_phone = '010'.$i.'0000';
        $emp_deptcode = $i;
        $emp_address = $i.'번지';

        $stmt = $conn->prepare("INSERT INTO employee(emp_name, emp_num, emp_phone, emp_deptcode, emp_address, emp_email) VALUES(?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $emp_name, $emp_num, $emp_phone, $emp_deptcode, $emp_address, $emp_email);
        $stmt->execute();
    }

// 댓글 처리를 위한 테이블 생성
    //기존 테이블 있는지 확인 후 
    $sql = "DROP TABLE IF EXISTS 'comment'";
    $conn->query($sql);
    //생성 (Foreign key 부분 잘 확인할 것)
    $sql = "CREATE TABLE IF NOT EXISTS `".$dbname."`.`comment` (
        `co_id` INT(8) NOT NULL AUTO_INCREMENT , 
        `emp_id` INT(8) NOT NULL , 
        `co_writer` VARCHAR(50) NOT NULL , 
        `co_contents` VARCHAR(600) NOT NULL , 
        `co_date` DATETIME on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
        PRIMARY KEY (`co_id`)
        ) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci";
    $conn->query($sql);

    $stmt->close();

if ($conn != null) {
    $conn->close();
    echo "<script>alert('DBMS와 연결을 종료합니다.')</script>";
}
?>