<?php
    require '../util/dbconfig.php';
    require_once '../util/loginchk.php';

    if($chk_login){
        // id값을 못물어오면 board_id로 해보장.
        $id = $_GET['id'];
        $co_no = $_GET['co_no'];
        $sql = "DELETE FROM b_comments WHERE co_no=".$co_no;
        
        if ($conn->query($sql) ==TRUE) {
            echo outmsg(DELETE_SUCCESS);
        }else{
            echo outmsg(DELETE_FAIL);
        }$conn->close();

        header('Location:../board/detailview.php?id='.$id);
    }else {
        echo outmsg(LOGIN_NEED);
        echo "<a href='../index.php'>홈 화면으로</a>";
    }
?>