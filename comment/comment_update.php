<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <title>Document</title>
</head>

<body>
<?php
    require '../util/dbconfig.php';
    require_once '../util/loginchk.php';
    if ($chk_login) {
?>
    <script defer src="../js/comments_update.js"></script>
    <div class="comment_view">
<?php
        $board_id = $_POST['board_id'];
        $co_no = $_POST['co_no'];
        $co_contents = $_POST['co_contents'];
        $sql = "UPDATE b_comment SET co_contents = '".$co_contents . "' WHERE co_no = " .$co_no;
        
        if( $conn->query($sql) == TRUE ){
            echo outmsg(UPDATE_SUCCESS);
            header('Location: ../board/detailview.php?id='.$board_id);
        }else {
            echo outmsg(UPDATE_FAIL);
        }
?>
    </div>
    <!-- </div> -->
<?php
}else {
    echo outmsg(LOGIN_NEED);
    echo "<a href='../index.php'>인덱스페이지로</a>";
    }
?>
</body>

</html>