<!-- 
  파일명 : init_createtbl.php
  최초작업자 : swcodingschool
  최초작성일자 : 2021-12-28
  업데이트일자 : 2022-01-12
  
  기능: 
  board 앱의 댓글 저장을 위한 comment 테이블을 생성한다.
  이 코드는 납품시 최초 1 회 실행하며, 현재 버전은 백업에 대한 고려는 하지 않았다.

-->

<?php
require "../util/dbconfig.php";

// 기존 테이블이 있으면 삭제하고 새롭게 생성하도록 질의 구성
// 질의 실행과 동시에 실행 결과에 따라 메시지 출력
$sql = "DROP TABLE IF EXISTS b_comment";
if ($conn->query($sql) == TRUE) {
  if (DBG) echo outmsg(DROPTBL_SUCCESS);
}

// 테이블을 생성한다.
// 데이터베이스명과 사용자명에 더 많은 유연성을 부여하며
// 테이블 생성시 데이터베이스 이름을 붙이는 부분을 생략함!!
// $sql = "CREATE TABLE `toymembership`.`users` (
  $sql = "CREATE TABLE `b_comment` ( 
    `co_no` INT(8) NOT NULL AUTO_INCREMENT , 
    `board_id` INT(8) NOT NULL COMMENT 'board records id', 
    `username` VARCHAR(24) NOT NULL COMMENT 'user account' , 
    `co_contents` TEXT NOT NULL COMMENT 'comment contents' , 
    `co_uptime` DATETIME on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'update time' , 
    PRIMARY KEY (`co_no`)
    ) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci COMMENT = 'board comments table';";

// 위 질의를 실행하고 실행결과에 따라 성공/실패 메시지 출력
if ($conn->query($sql) == TRUE) {
  if (DBG) echo outmsg(CREATETBL_SUCCESS);
} else {
  echo outmsg( CREATETBL_FAIL);
}

// 데이터베이스 연결 인터페이스 리소스를 반납한다.
$conn->close();

// 프로세스 플로우를 인덱스 페이지로 돌려준다.
// header('Location: index.php');
// 작업 실행 단계별 메시지 확인을 위해 Confrim and return to back하도록 수정함!!
// 백그라운드로 처리되도록 할 경우 위 코드로 대체 할 것!!
echo "<a href='./boardlist.php'>Confirm and Return to back</a>";
// ..은 위에, 위에 폴더를 말함
?>