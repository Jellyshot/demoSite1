<!-- 
  파일명 : user_loginprocess.php
  최초작업자 : swcodingschool
  최초작성일자 : 2021-12-28
  업데이트일자 : 2022-01-03
  
  기능: 
  user_login.php 로그인 화면에서 입력된 값을 받아 
  유저명과 비밀번호를 확인, 등록된 사용자임을 확인한다.
-->

<?php
// 여기부터는 로그인 성공시 세션관리를 위한 코드 추가
session_start(); //이건 항상 최상단에 있어야함.
// db연결 준비
require_once "../util/dbconfig.php";

// 데이터베이스 작업 전, 로그인 화면으로 부터 값을 전달 받고
//$username = $_POST['username'];
//$passwd = $_POST['passwd'];
$username = $_REQUEST['username'];
$passwd = $_REQUEST['passwd'];
//
// 세션관리를 위하여 클라이언트 정보 수집
$userip = get_client_ip();

// 사용자 계정 존재 여부 확인을 위한 질의 구성
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ? and passwd = sha2(?,256)");
$stmt->bind_param("ss", $username, $passwd);

$stmt->execute();
$result = $stmt->get_result();
$row = mysqli_fetch_array($result);

if (!empty($row['username'])) {
  echo outmsg(LOGIN_SUCCESS);

  // 여기부터 로그인 성공시 세션관리를 위한 추가 코드
  //session_start();
  echo outmsg('SESSION_CREATE');
  /*echo outmsg($userip); 
  로그인 상태가 유지된다면 쿠키를 싣겠다! 하지만 지금은 작동하지 않음 */

  if(isset($_REQUEST['chkbox'])){
    $a = setcookie('username', $username, time() + 60);
    $b = setcookie('passwd', $passwd, time() + 60);
  } //여기서 +60은 한시간동안 유지되는 쿠키를 만들어랏

  // <세션 생성 코드>
  $_SESSION['username']=$username;
  $_SESSION['userip']=$userip;
  // username과 userip가 맞으면 로그인 처리 하겠다.
  // 여기까지 로그인 성공시 세션관리를 위한 추가 코드

  $conn->close();
  //header('Location: user_list.php');
  echo "<a href='./user_userlist.php'>목록보기</a>";
} else {
  echo outmsg(LOGIN_FAIL);
  $conn->close();
  //header('Location: index.php');
  echo "<a href=../index.php'>index 페이지로</a>";
}


?>