<!-- 
  파일명 : index.php
  최초작업자 : swcodingschool
  최초작성일자 : 2022-01-01
  업데이트일자 : 2022-01-03
  
  기능: 
  demosite1 프로젝트 폴더의 최상위 index 파일로써,
  하위 app 폴더를 연결하는 역할을 한다.
-->
<!--
  session 관리 목적 추가
-->
<?php
require_once './util/utility.php';
// .하나는 내 기준 아래, ..은 내기준 위에 폴더
require_once './util/loginchk.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership Management</title>
    <link rel="stylesheet" href="css/index.css">
</head>

<body>

    <!-- Logo, Memga menu's, Introduction Video link, and Login Button -->
    <header>
        <div class="headeritem"><img src="./img/J_logo-001.png" alt="logo.png"></div>
        <div class="headeritem">Megamenu1</div>
        <div class="headeritem">Megamenu2</div>
        <videos></videos>
        <div class="loginlink"></div>
    </header>
    <!-- -->

    <?php
    if (!$chk_login) {  // 로그인 상태가 아니라면
    ?>
    <ul>
        <li id='trglgnModal'>login</li>
        <!-- 여기부터 login modal -->
        <div id='lgnModal' class='modal'>
            <!-- loginform in modal -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <form action="./membership/user_loginprocess.php" method="POST" class="loginbox">
                    <label for="username"><b>Username</b></label><input type="text" name="username" placeholder="Enter Username" required />
                    <label for="passwd"><b>Password </label><input type="password" name="passwd" placeholder="Enter Password" required />
                    <button type=submit>Login</button><br>
                    <label>
                        <input type="checkbox" value="yes" name="chkbox">Remember me
                    </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="./membership/user_regist.php">회원가입</a>
                </form>
            </div>
            <!-- loginform in modal 끝 -->
        </div>
        <!-- login modal 끝 -->
    <?php 
    } else {
        echo $_SESSION['username']; ?>
        <button?><a href="./membership/user_logout.php">logout</a></button>
        <?php
    }
        ?>
        

        <!-- -->
        <nav>
            
                <li onclick="location.href='./memo/info.php'">Memo</li>
                <li onclick="location.href='./board/boardlist.php'">Board</li>
                <li>Blog</li>
    </ul>
        </nav>
        <main>
        </main>
        <footer>
        </footer>
        <script src='./js/login.js'></script>
</body>

</html>