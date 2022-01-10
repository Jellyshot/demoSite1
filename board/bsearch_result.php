<?php
    require '../util/dbconfig.php';
    // require_once '../util/loginchk.php';

?>

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
<div class="board_area">
    <?php
        $catagory = $_GET['s_catgo'];
        $search = $_GET['search'];
        $sql = "SELECT * FROM board WHERE $catagory like '%$search%' order by uptime desc";
        $resultset = $conn->query($sql);
        
        if($resultset->num_rows>=0){
    ?>
    <h1><?=$catagory?>에서 <?=$search ?>로 검색한 결과</h1><br>
    <table>
        <thead>
            <tr>
                <td>Title</td>
                <td>UserName</td>
                <td>Writing Date</td>
                <td>Last Update</td>
                <td>Hits</td>
            </tr>
        </thead>
        <tbody>
    <?php
        while ($row = $resultset->fetch_array()) {
            echo "<tr><td><a href='detailview.php?id=" . $row['id'] . "'>" . (mb_substr($row['title'], 0, 20, "utf-8")) . "</a></td><td>".$row['username']."</td><td>".$row['wrtime']."</td><td>".$row['uptime']."</td><td>".$row['hits']."</td></tr>";
        }
    ?>
        </tbody>
    </table>
    <?php
    }
    ?>
    </div>
    <div class="search_box">
            <form action="./bsearch_result.php" method="get">
                <select name="s_catgo">
                    <option value="title">Title</option>
                    <option value="username">UserName</option>
                    <option value="contents">Contents</option>
                </select>
                <input type="search" name="search" size="30" style="font-size: 20px;" required />
                <button style="padding: 4px;margin: 3px;">Search</button>
        </form>
        </div>
</body>
</html>