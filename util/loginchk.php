<!-- 로그인여부에 따라 권한을 부여하기 위한 php코드. -->
<?php
  session_start();
  if(isset($_SESSION['username'])) {
    $chk_login = TRUE;
  }else { 
    $chk_login = FALSE;
  }
?>