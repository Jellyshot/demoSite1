<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
    //1. 데이터 베이스 연결
    $conn = new mysqli('localhost', 'remind', 'remind', 'remind');
    // $sql = " use remind ";

        //데이터 베이스 연결에 문제가 발생했을때 프로그램 정지 시키기.
        if ($conn->connect_error) {
        die("데이터베이스 연결에 문제가 있습니다.").$conn->connect_error;
        }

    //2. 페이지네이션을 하기 위한, 변수 설정
        //페이지당 들어갈 레코드 갯수
        $records_per_page = 10;

        //페이지 넘버값 설정. get한 page_no값이 있거나(isset) get한 page_no값이 ' '이  아니면 get한 page_no를 $page_no에 넣고, 아니면 1부터 시작한다.
        if (isset($_GET['page_no']) && ($_GET['page_no'])!='') {
            $page_no = $_GET['page_no'];
        }else {
            $page_no=1;
        }
        //offset값 설정
        $offset = ($page_no-1) * $records_per_page;
        
        //전체 페이지 수 계산
            //페이지수를 계산하기 위해 전체 레코드 갯수를 파악하는 쿼리 실행
            $sql = "SELECT COUNT(*) AS total_records FROM employee";
            $result = $conn->query($sql); 
            //query를 실행시키면 값만 주는게 아니라 테이블 뭉탱이 위에 여기서는 카운트한 값 하나를 올려 준다. 따라서 그 값만 가지고 올 수 있도록 row시켜야 함
            $total_records = $result->fetch_array();
            $total_records = $total_records['total_records'];

            //전체 레코드 수를 이용하여 페이지수를 계산함
            //나머지 레코드가 발생할 수 있기 때문에, 올림함수 ceil사용
            $total_no_of_pages = ceil($total_records/$records_per_page);

        //페이지네이션에 들어갈 페이지 갯수
        $pagination_range = 10;

        //페이지네이션의 첫 페이지와 마지막 페이지 설정.
        $startPage = floor(($page_no-1)/$pagination_range) * $pagination_range + 1;
            //floor함수는 나눗셈의 몫을 구하는 함수로, 12page에 있을 때, 페이지네이션은 11부터 시작해야 한다.
        $endPage = $startPage+($pagination_range - 1);
        if ($endPage > $total_no_of_pages) {
            $endPage = $total_no_of_pages;
        } //pagination_range의 값이 10이므로, endPage가 실제 전체 페이지 수보다 클 때는, 실제 전체페이지수가 endPage가 되도록 설정


        // 전 후 페이지 선택할 수 있는 버튼 값 설정
        $previous_page = $page_no - 1;
        $next_page = $page_no + 1;

    //3. 데이터를 불러오는 쿼리 실행
    $sql = "SELECT * FROM employee LIMIT ". $offset.", ".$records_per_page;
        //데이터를 불러온 후 resultset에 결과값 보관
        $resultset = $conn->query($sql);    
?>

<!-- 4. insert 및 update 시킨 employee table의 list를 보여줌 -->
    <h1 style="text-align: center;">인사정보 리스트</h1>

    <div class="buttons" style="width: 80%; margin:auto;">
        <a href="./insert.php">등록</a>
    </div>
    <br>

    <table style="text-align: center; width:80%; margin:auto;" >
        <tr>
            <th style="width: 10%;">No.</th>
            <th style="width: 10%;">이름</th>
            <th style="width: 10%;">사원번호</th>
            <th style="width: 10%;">전화번호</th>
            <th style="width: 10%;">입사일</th>
            <th style="width: 10%;">부서코드</th>
            <th style="width: 10%;">주소</th>
            <th style="width: 10%;">이메일</th>
        </tr>
<?php
    // resultset에 담은 열값이 돌아가는 동안 출력시키기.
    // $row[]안에 ''에는 table의 columm 이름이다..
    while ($row = $resultset->fetch_assoc()) {
?>
        <tr>
        <td><?= $row['id'] ?></td>
        <td><a href="./detailview.php?id=<?= $row['id'] ?>"><?= $row['emp_name'] ?></a></td>
        <td><?= $row['emp_num'] ?></td>
        <td><?= $row['emp_phone'] ?></td>
        <td><?= $row['emp_hiredate'] ?></td>
        <td><?= $row['emp_deptcode'] ?></td>
        <td><?= $row['emp_address'] ?></td>
        <td><?= $row['emp_email'] ?></td>
        </tr>
<?php
}
?>
    </table>


<!-- 5. 페이지네이션 보여지는 부분 시작 -->
<br>
<div class="pagination" style="text-align:center;">
<?php
    
    //현재 페이지 알려주기
    echo "current Page : ".$page_no." / ".$total_no_of_pages. "<br>";
    //First page 버튼 보여주기
    if($page_no > 1){
        echo "<a href='list.php?page_no=1'>First </a>";
    }
    //previous_page 버튼 보여주기
    if ($page_no > 1) {
        echo "<a href='list.php?page_no=".$previous_page."'>&#8678; </a>";
    }
    // pagination 버튼 보여주기
    for($count = $startPage; $count <= $endPage; $count++){
        echo "<a href='list.php?page_no=".$count."'>".$count." </a>";
    }
    //next_page 버튼 보여주기
    if ($page_no < $total_no_of_pages) {
        echo "<a href='list.php?page_no=".$next_page."'>&#8680; </a>";
    }
    //Last page버튼 보여주기
    if($page_no < $total_no_of_pages){
        echo "<a href='list.php?page_no=".$total_no_of_pages."'>Last </a>";
    }
?>
</div>


<!-- 6. 값이 전부 다 출력 된 후 table이 닫힌 후에 리소스 반납 -->
<?php

    $resultset->close();
    $conn->close();
?>
</body>
</html>