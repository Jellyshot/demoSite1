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
    <link rel="stylesheet" href="./css/boardlist.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <title>Document</title>
</head>

<body>
    <script defer src="../js/nav.js"></script>
    <!-- pagination 시작 -->
    <?php
    if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
        $page_no = $_GET['page_no'];
    }else{
        $page_no = 1;
    }

    // 검색용 카테고리와 키워드 get
    $category = $_GET['s_catgo'];
    $search = $_GET['search'];

    // 변수값 설정
    $total_records_per_page = 10;
    $offset = ($page_no-1) * $total_records_per_page;
    // 쿼리 실행(전체 페이지 수 계산)
    $result_count = mysqli_query(
        $conn,
        "SELECT COUNT(*) As total_records FROM `board` WHERE ".$category." like '%".$search."%';"
    );
    $total_records = mysqli_fetch_array($result_count);
    //총 게시물수
    $total_records = $total_records['total_records'];
    //총 페이지 수
    $total_no_of_pages = ceil($total_records / $total_records_per_page);
    $previous_page = ($page_no>10? $page_no-10 : $page_no-1);
    $next_page = ($page_no < $total_records-10 ? $page_no+10 : $page_no+1);
    
    $start_page = floor($page_no/$total_records_per_page)*$total_records_per_page+1;
    //floor를 주는 이유 : 몫을 구하기 위해서.

    $end_page = min($start_page+($total_records_per_page - 1), $total_no_of_pages);
    // if($end_page > $total_no_of_pages){
    //     $end_page = $total_no_of_pages;
    // }

?>
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
    <br />
    <div class="board_area">
        <?php
        

        $sql = "SELECT * FROM board WHERE $category like '%$search%' order by uptime desc LIMIT $offset, $total_records_per_page";
        $resultset = $conn->query($sql);
        $row = mysqli_num_rows($resultset);
        

        if ($resultset->num_rows >= 0) {
        ?>
            <h1><?= $category ?>에서 <?= $search ?>로 검색한 결과</h1>
            <h3 style="text-align:center;">&#91;검색된 결과 : 총 <?= $total_records ?> 개&#93;</h3><br>
            <a class="back" href="../board/boardlist.php">&#9754;리스트로 돌아가기</a>
            <table>
                <thead>
                    <tr>
                        <th style="width: 10%">ID</th>
                        <th style="width: 10%;">UserName</th>
                        <th style="width: 40%;">Title</th>
                        <th style="width: 15%;">Writing Date</th>
                        <th style="width: 15%;">Last Update</th>
                        <th style="width: 10%;">Hits</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $resultset->fetch_array()) {
                        echo "<tr><td>" . $row['id'] . "</td><td>" . $row['username'] . "</td><td><a href='detailview.php?id=" . $row['id'] . "'>" . (mb_substr($row['title'], 0, 20, "utf-8")) . "</a></td><td>" . $row['wrtime'] . "</td><td>" . $row['uptime'] . "</td><td>" . $row['hits'] . "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        <?php
        }
        ?>
    </div>
    <!-- pagination 버튼 만들기 -->
    <br><br>
    <ul class="pagination">
<?php 
    if ($page_no > 1) {
    // 링크 확인. 검색에서 온거니까 페이지뿐만 아니라 카테고리와 서치값을 가져와야함
        echo "<li><a href='?page_no=1&s_catgo=$category&search=$search'>&lsaquo;&lsaquo; First</a></li>";
    }
?>
    <li <?php if ($page_no <= 1) {
        echo "class='disabled'";  
    } ?>>
        <a <?php if ($page_no > 1) {
            echo "href='?page_no=$previous_page&s_catgo=$category&search=$search'";
        } ?>>Previous</a>
        </li>
<?php
    for ($counter = $start_page; $counter <= $end_page ; $counter++) { if ($counter==$page_no) { echo "<li class = 'active'><a>$counter</a></li>" ; 
    }else{ echo "<li><a href='?page_no=$counter&s_catgo=$category&search=$search'>$counter</a></li>" ; } } 
?>
        <li <?php if ($page_no >= $total_no_of_pages) {
                    echo "class='disabled'";
                } ?>>
        <a <?php if ($page_no < $total_no_of_pages) {
                        echo "href='?page_no=$next_page&s_catgo=$category&search=$search'";
                    } ?>>Next</a></li>
            <?php if ($page_no < $total_no_of_pages) {
                echo "<li><a href='?page_no=$total_no_of_pages&s_catgo=$category&search=$search'>Last &rsaquo;&rsaquo;</a></li>";
            } ?>
    </ul>
    <br/><br/>
    <div class="search_box">
        <form action="./bsearch_result.php" method="get">
            <select name="s_catgo">
                <option value="title">Title</option>
                <option value="username">UserName</option>
                <option value="contents">Contents</option>
            </select>
            <input type="search" name="search" size="40" style="font-size: 14px;" required />
            <button>Search</button>
        </form>
    </div>
</body>

</html>