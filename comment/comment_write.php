<?php
    require "../util/dbconfig.php";
    require_once "../util/loginchk.php";

    if($chk_login){
    $co_no=$_POST['co_no'];
    $board_id = $_POST['id'];
    $username = $_SESSION['username'];
    $co_contents = $_POST['co_contents'];

    $stmt = $conn->prepare("INSERT INTO b_comment(board_id, username, co_contents) VALUE (?, ?, ?, ?)");
    $stmt -> bind_param("iss", $board_id, $username, $co_contents);
    $stmt->execute();

    if ($stmt) {
        echo outmsg(COMMENT_SUCCESS);
        $conn->close();
    }header('Location:../board/detailview.php?id='.$board_id);
    
    }else{
        echo outmsg(LOGIN_NEED);
        echo "<a href= '../index.php'>홈 화면으로</a>";
    }
?>D