<?php
    require "../util/dbconfig.php";
    require_once "../util/loginchk.php"
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>comment</title>
</head>
<body>
    <form action="comment_update.php" method="POST">
        <input type="hidden" name="board_id" value="<?= $id ?>">
        <table>
            <tr><th>Username</th>
            <th><input type="text" name="username" value="<?= 'UserName : ' . $_SESSION['username'] ?>" readonly></th></tr>
            <tr><td>Contents</td><td><input type="text" name="co_contents" placeholder="Comments..."></td></tr>
        </table>
        <input type="submit" value="Save">
    </form>
</body>
</html>