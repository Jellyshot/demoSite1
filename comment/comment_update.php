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
    <script defer src="../js/comments_update.js"></script>

    <div class="comment_view">
        <?php
        $sql = "SELECT * FROM comment WHERE board_id = " . $board_id . " ORDER BY id DESC";
        $resultset = $conn->query($sql);
        if (true) {
        ?>
            <?php
            while ($row = $resultset->fetch_assoc()) {
                $comment_id = $row['id'];
                $contents = $row['contents'];
            ?>
                <div class="default_display" id="comment_default_display<?= $comment_id ?>">
                    <table>
                        <tr>
                            <td><?= $row['c_username'] ?></td>
                        </tr>
                        <tr>
                            <td><?= $row['likecnt'] ?></td>
                        </tr>
                        <tr>
                            <td><?= $row['contents'] ?></td>
                        </tr>
                        <tr>
                            <td><?= $row['writtendate'] ?></td>
                        </tr>
                    </table>

                    <div class="comment_bottom">
                        <!-- 로그인한 사용자와 작성자가 같으면 수정과 삭제 버튼 활성화 -->
                        <?php
                        if ($username == $writer) {
                        ?>
                            <a href="./bd_cm_deleteprocess.php?comment_id=<?= $comment_id ?>&board_id=<?= $board_id ?>">삭제</a>
                            <a onclick='comment_edit(<?= $comment_id ?>)'>수정</a>
                        <?php
                        }
                        ?>
                        <a href="./bd_cm_likeprocess.php?comment_id=<?= $comment_id ?>&board_id=<?= $board_id ?>">좋아요</a>
                    </div>
                </div>


                <div class="comment_create default_hide" id="comment_update_display<?= $comment_id ?>">
                    <form action="./bd_cm_process.php" method="POST">
                        <input type="hidden" name="board_id" value="<?= $board_id ?>">
                        <input type="text" name="c_username" value="<?= $username ?>" readonly><br>
                        <textarea name="description"><?= $contents ?></textarea> <br>

                        <input type=submit value="완료">
                        <input type=reset value="취소" onclick='comment_edit(<?= $comment_id ?>)'>
                    </form>
                    <br>
                </div>



            <?php
            }
            ?>


        <?php
        }
        ?>



    </div>
    </div>
</body>

</html>