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
    <h1>게시물 목록</h1>
    <br>
    <div class=" buttons">
        <a href="./create.php"><button>New</button></a>
        <a href="" onclick="history.back(-1); return false"><button>Back</button></a>
        <a href="./create100.php"><button>100개생성</button></a>
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
        //한 페이지에 보여줄 리스트 개수
        $total_records_per_page = 10;
        $offset = ($page_no - 1) * $total_records_per_page;

        // 쿼리 실행(전체 페이지 수 계산)
        $result_count = mysqli_query(
            $conn,
            "SELECT COUNT(*) As total_records FROM `board`"
        );
        //$id = $_GET['id'];
        $total_records = mysqli_fetch_array($result_count);
        //총 게시물수
        $total_records = $total_records['total_records'];
        //총 페이지 수
        $total_no_of_pages = ceil($total_records / $total_records_per_page);
        $previous_page = ($page_no > 10 ? $page_no - 10 : $page_no - 1);
        $next_page = ($page_no < $total_records - 10 ? $page_no + 10 : $page_no + 1);

        $start_page = floor($page_no / $total_records_per_page) * $total_records_per_page + 1;
        //floor를 주는 이유 : 몫을 구하기 위해서.

        $end_page = $start_page + ($total_records_per_page - 1);
        if ($end_page > $total_no_of_pages) {
            $end_page = $total_no_of_pages;
        }

        // board 값 테이블로 가져오기.
        $sql = "SELECT * FROM board LIMIT $offset, $total_records_per_page";
        $resultset = $conn->query($sql);


        if ($resultset->num_rows >= 0) {
            echo "<table>
            <thead>
            <tr>
            <th style=width: 10%>ID</th>
            <th style=width: 10%>UserName</th>
            <th style=width: 10%>Title</th>
            <th style=width: 10%>Writing Date</th>
            <th style=width: 10%>Last Update</th>
            <th style=width: 10%>Hits</th>
            </tr>
            </thead>";
            // out data of each row
            while ($row = $resultset->fetch_assoc()) {
                // 게시글 1개에 대한 댓글수 카운트해오기
                $stmt2 = mysqli_query($conn, "SELECT COUNT(*) AS co_records FROM b_comment WHERE board_id=". $row['id']);
                $co_records = mysqli_fetch_array($stmt2);
                $co_records = $co_records['co_records']; 
        // 여기까지...

                echo "<tr><td>" . $row['id'] . "</td><td>" . $row['username'] . "</td><td><a href='detailview.php?id=" . $row['id'] . "'>" . (mb_substr($row['title'], 0, 20, "utf-8"))."&#91;". $co_records. "&#93</a></td><td>" . $row['wrtime'] . "</td><td>" . $row['uptime'] . "</td><td>" . $row['hits'] . "</td></tr>";
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

            for ($counter = $start_page; $counter <= $end_page; $counter++) {
                if ($counter == $page_no) {
                    echo "<li class = 'active'><a>$counter</a></li>";
                } else {
                    echo "<li><a href='?page_no=$counter'>$counter</a></li>";
                }
            }
            ?>
            <li <?php if ($page_no >= $total_no_of_pages) {
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
    <br />
    <br />
    <div class="search_box">
        <form action="./bsearch_result.php" method="get">
            <select name="s_catgo">
                <option value="title">Title</option>
                <option value="username">UserName</option>
                <option value="contents">Contents</option>
            </select>
            <input type="search" name="search" size="40" style="font-size: 14px;" required /><button>Search</button>
        </form>
    </div>


</body>

</html>