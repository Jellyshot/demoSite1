
<?php

require "../util/dbconfig.php";
require_once '../util/loginchk.php';

// 이미지 및 파일을 저장할 upload폴더의 경로를 지정하는 변수를 선언
$upload_path = './uploadfiles/';


if ($chk_login) {

$id = $_POST['id'];
$title = $_POST['title'];
$contents = $_POST['contents'];
$username = $_SESSION['username'];

/* php의 글로벌변수 
  $_FILES['userfile']['name'or'type'or'size'or'tmp_name'or'error']
   첫번째 인자인 userfile은 input태그의 name을 말하며, 두번째 인자는 여러 변수가 들어갈 수 있다. */
  
  if (is_uploaded_file($_FILES['uploadfiles']['tmp_name'])) {
     //업로드된 파일이 있으면 파일이름 중복을 피하기 위해 타임스태프를 파일명 앞에 찍은후 파일 가져오기.
    $filename = time()."_".$_FILES['uploadfiles']['name'];

    //업로드된 파일을 upload폴더로 이동시킴
    //bool move_uploaded_file ( string $filename , string $destination ) 업로드한 파일을 서버에 저장시키는 함수
    if (move_uploaded_file($_FILES['uploadfiles']['tmp_name'],$upload_path.$filename)) {
      if(DBG) echo outmsg(UPLOAD_SUCCESS);
      //업로드에 성공하면 file이 포함된 INSERT 구문 실행
      $stmt = $conn->prepare("INSERT INTO board(id, title, contents, username, uploadfiles)VALUES(?, ?, ?, ?, ?)");
      $stmt->bind_param("issss", $id, $title, $contents, $username, $filename);
      $stmt->execute();
    }else {
      if(DBG) echo outmsg(UPLOAD_FAIL);
    }
    //업로드된 파일이 없는 텍스트 뿐인 게시물이면 기존 INSERT 구문 실행.
  }else{
    $stmt = $conn->prepare("INSERT INTO board(id, title, contents, username)VALUES(?, ?, ?, ?)");
    $stmt->bind_param("isss", $id, $title, $contents, $username);
    $stmt->execute();
  }

  // 데이터베이스 연결 인터페이스 리소스를 반납한다.
  $stmt->close();
  $conn->close();

  //실행완료 메세지 출력 후, LIST로 이동.
  echo outmsg(COMMIT_CODE);
  header('Location: ../board/boardlist.php');

} else {
  echo outmsg(LOGIN_NEED);
  echo "<a href='../index.php'>인덱스페이지로</a>";
}
?>
  
