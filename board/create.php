<?php
require '../util/dbconfig.php';

// 로그인한 상태일 때만 이 페이지 내용을 확인할 수 있다.
require_once '../util/loginchk.php';

if ($chk_login) {

    // $id = $_SESSION['id'];
    // $sql = "SELECT * FROM board WHERE id = " . $id;

    // $result = $conn->query($sql);
    // $row = $result->fetch_array();

    // $username = $row['username'];
    // $title =  $row['title'];
    // $contents = $row['contents'];
    // $wrtime = $row['wrtime'];
    // $uptime = $row['uptime'];
    // $hits = $row['hits'];
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./css/create.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
        <title>Document</title>
    </head>

    <body>
        <script defer src="../js/nav.js"></script>
        <header>
            <div class="topnav">
                <div id="myLinks">
                <sapn><a href="../index.php">Home</a></sapn>
                <sapn><a href="../memo/info.php">Memo</a></sapn>
                <span><a href="./boardlist.php">Board</a></span>
                <span><a href="">Blog</a></span>
                <span><a href="">Account</a></span>
                </div>
                <div class="menu_icon">
                    <a href="javascript:void(0);" class="icon" onclick="myFunction()">&#9776;</a>
                </div>
            </div>
        </header>
        <h1>New Board</h1>
        <form class=form action="./bcreate_process.php" method="post">
            <div class="date">
                <?php
                $currdt = date("Y-m-d h:i:s");
                echo "작성일시: " . $currdt;
                ?>
            </div>
            <br>
            <div class="contents">
                <input class="hiddenId" type="hidden" name="id" value="<?= $id ?>" />
                <input type="text" name="username" value="<?= 'UserName : ' . $_SESSION['username'] ?>" readonly>
                <p><input type="text" name="title" placeholder="Title" required /></p>
                <hr>
                <p><textarea name="contents" placeholder="Contents" cols="94" rows="15" required></textarea></p>
            </div>
            <div class="buttons">
                <span><input type="submit" value="Save" style="font-size: 16px;" /></span>
                <span><input type="reset" value="Reset" style="font-size: 16px;" /></span>
                <span><input type="button" value="List" style="font-size: 16px;" onclick="history.back(-1);" /></span>
            </div>
        </form>
    </body>
<?php
} else {
    echo outmsg(LOGIN_NEED);
    echo "<a href='../index.php'>인덱스페이지로</a>";
}
?>

    </html>