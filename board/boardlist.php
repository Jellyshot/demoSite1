<?php
// db연결 준비
require "../util/dbconfig.php";
?>
<!-- 리스트 작성 시작. -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/boardlist.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <title>Document</title>
</head>

<body>
    <header>
        <div class="topnav">
        <div class="menu_icon">
            <sapn>&#9776;</sapn>
        </div>
        </div>
    </header>
    <h1>게시물 목록</h1>
    <br>
    <div class="buttons">
        <a href="./create.php"><button>New</button></a>
        <a href="./info.php"><button>Back</button></a>
    </div>
    <br>
    <div class="container">
        <?php
        // pagination 시작
        if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
            $page_no = $_GET['page_no'];
        } else {
            $page_no = 1;
        }
        // pagination을 위한 변수 값 설정
        $total_records_per_page = 10;
        $offset = ($page_no - 1) * $total_records_per_page;
        $previous_page = $page_no - 1;
        $next_page = $page_no + 1;
        // $adjacents = "2";

        // 쿼리 실행
        $result_count = mysqli_query(
            $conn,
            "SELECT COUNT(*) As total_records FROM `board`"
        );

        $total_records = mysqli_fetch_array($result_count);
        $total_records = $total_records['total_records'];
        $total_no_of_pages = ceil($total_records / $total_records_per_page);
        $second_last = $total_no_of_pages - 1;

        // board 값 테이블로 가져오기.
        $sql = "SELECT * FROM board LIMIT $offset, $total_records_per_page";
        $resultset = $conn->query($sql);


        if ($resultset->num_rows >= 0) {
            echo "<table>
            <thead>
            <tr><th>ID</th><th>UserName</th><th>Title</th><th>Writing Date</th><th>Last Update</th><th>Hits</th></tr></thead>";
            // out data of each row
            while ($row = $resultset->fetch_assoc()) {
                echo "<tr><td>" . $row['id'] . "</td><td>" . $row['username'] . "</td><td><a href='detailview.php?id=" . $row['id'] . "'>" . (mb_substr($row['title'], 0, 20, "utf-8")) . "</a></td><td>" . $row['wrtime'] . "</td><td>" . $row['uptime'] . "</td><td>" . $row['hits'] . "</td></tr>";
            }
            echo "</table>";
        }
        ?>
        <!-- pagination 버튼 만들기 -->
        <br><br>
        <ul class="pagination">
            <?php if ($page_no > 1) {
                echo "<li><a href='?page_no=1'>&lsaquo;&lsaquo; First</a></li>";
            }
            ?>
            <li <?php if ($page_no <= 1) {
                    echo "class='disabled'";  //class=disabled는 css속성값을 주기위해 선언한 것.
            } ?>>
            <a <?php if ($page_no > 1) {
                    echo "href='?page_no=$previous_page'";
            } ?>>Previous</a>
            </li>
            <?php
            if ($total_no_of_pages <= 10){
                for ($counter=1; $counter <=$total_no_of_pages; $counter++){
                    if ($counter==$page_no) {
                        echo "<li class='active'><a>$counter</a></li>" ; 
                    }else{        /* 현재페이지는 a태크에 링크를 주지 않지만, */
                        echo "<li><a href='?page_no=$counter'>$counter</a></li>" ; 
                    }             /* 현재 페이지 외의 숫자에는 이동 링크를 준다 */
                }
            }?><li <?php if ($page_no >= $total_no_of_pages) {
                            echo "class='disabled'";
                            } ?>>
                <a <?php if ($page_no < $total_no_of_pages) {
                        echo "href='?page_no=$next_page'";
                    } ?>>Next</a>
                </li>
                <?php if ($page_no < $total_no_of_pages) {
                    echo "<li><a href='?page_no=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
                } ?>
        </ul>
    </div>
</body>

</html>