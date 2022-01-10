<?php
require "../util/dbconfig.php";

// 기존 테이블이 있으면 삭제하고 새롭게 생성하도록 질의 구성
// 질의 실행과 동시에 실행 결과에 따라 메시지 출력
$sql = "DROP TABLE IF EXISTS users";
if ($conn->query($sql) == TRUE) {
    if (DBG) echo outmsg(DROPTBL_SUCCESS);
}
// 테이블을 생성한다.

$sql = "CREATE TABLE `password_reset_temp` (
    `email` VARCHAR(50) NOT NULL  , 
    `key` VARCHAR(250) NOT NULL,
    `expDate` DATETIME NOT NULL , 
    ) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci COMMENT = 'users password reset table';";

// 위 질의를 실행하고 실행결과에 따라 성공/실패 메시지 출력
if ($conn->query($sql) == TRUE) {
if (DBG) echo outmsg(PWD_RESET_SUCCESS);
} else {
    echo outmsg(PWD_RESET_FAIL);
}

// 데이터베이스 연결 인터페이스 리소스를 반납한다.
$conn->close();

// 프로세스 플로우를 인덱스 페이지로 돌려준다.
// header('Location: index.php');
// 작업 실행 단계별 메시지 확인을 위해 Confrim and return to back하도록 수정함!!
// 백그라운드로 처리되도록 할 경우 위 코드로 대체 할 것!!
echo "<a href='../memo/app_initiate.php'>Confirm and Return to back</a>";
