<?php
    session_start();
    unset($_SESSION["username"]);
    unset($_SESSION["userip"]);
    setcookie("username", ""); //쿠키를 empty로 바꿈.
    setcookie("passwd", "");
    header("Location: ../index.php");
?>
<!-- unset이 session만든거 날리는거. -->