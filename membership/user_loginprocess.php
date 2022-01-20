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
// 1. 세션을 사용하기 위해 항상 최상단에 올려줘야 함.
session_start(); 

// 2. db연결
require_once "../util/dbconfig.php";


// 3. 로그인form에서 가져온 값을 저장하는데 쿠키까지 받을 수 있어서 request를 씀.
$username = $_REQUEST['username'];
$passwd = $_REQUEST['passwd'];


  // 3.1. 세션관리를 위하여 클라이언트 정보 수집
  $userip = get_client_ip();

// 4. 사용자 계정 존재 여부 확인
//  4.1. 일단 users 테이블에 있는 아이디와 비밀번호 값을 불러와 $row에 저장시키고
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? and passwd = sha2(?,256)");
    $stmt->bind_param("ss", $username, $passwd);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = mysqli_fetch_array($result);

//  4.2. 테이블에 등록된 사람에게만 세션 생성해주기
    if (!empty($row['username'])) {
      echo outmsg(LOGIN_SUCCESS);
      echo outmsg('SESSION_CREATE');

//  로그인에 성공하면 쿠키를 만들어주는 setcookie 
//  여기서 +60은 한시간동안 유지되는 쿠키를 만들어랏
  if(isset($_REQUEST['chkbox'])){
    $a = setcookie('username', $username, time() + 60);
    $b = setcookie('passwd', $passwd, time() + 60);
  } 

//  4.3. ✔ <세션 생성 코드>
//  세션을 생성할 때는 반드시 php 가장 상단에 session start(); ❗
    $_SESSION['username'] = $username;
    $_SESSION['userip'] = $userip;

// username과 userip가 맞으면 세션값을 만들어 주고,
// 그 이후로는 세션값이 있는 사람에게만 권한 부여(loginchk.php)
// 여기까지 로그인 성공시 세션관리를 위한 추가 코드

  $conn->close();
  header('Location: ../index.php');
  echo "<a href='./user_userlist.php'>목록보기</a>";
} else {
  echo outmsg(LOGIN_FAIL);
  $conn->close();
  //header('Location: index.php');
  echo "<a href=/index.php>index 페이지로</a>";
}


?>