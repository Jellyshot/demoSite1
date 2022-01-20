<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .comment_box{
            border-top: 1px solid lightblue;
            border-bottom: 1px solid lightblue;
            border-collapse: collapse;
        }
        .coUpdateForm{
            display: none;
        }

    </style>
    <title>Document</title>
</head>
<body>
<?php
    $conn = new mysqli("localhost", "remind", "remind", "remind");
    $id = $_GET['id'];

    $sql = "SELECT * FROM employee WHERE id=".$id;
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $login_username = "임시로긴유저";
?>
    <h1>개인정보 상세보기</h1>
    <table>
    <tr>
        <td>No.: <?= $row['id'] ?></td>
        <td>이름: <?= $row['emp_name'] ?></td>
        <td>사원번호: <?= $row['emp_num'] ?></td>
    </tr>
    <tr>
        <td>전화번호: <?= $row['emp_phone'] ?></td>
        <td>입사일: <?= $row['emp_hiredate'] ?></td>
        <td>부서코드: <?= $row['emp_deptcode'] ?></td>
        <td>이메일: <?= $row['emp_email'] ?></td>
    </tr>
    <tr>
        <td>주소: <?= $row['emp_address'] ?></td>
    </tr>
    </table>
    <div class="buttons">
        <a href="update.php?id=<?= $id ?>">수정</a>
        <a href="deleteProcess.php?id=<?= $id ?>">삭제</a>
        <a href="list.php">목록으로</a>
    </div>
    <hr>

    <!-- 여기부터 댓글창 -->
    <!-- 1. 댓글 Create form 생성 -->
    <form action="commentInsertProcess.php" method="POST">
        <input type="hidden" name="co_writer" value=" <?= $login_username ?>" /><br>
        <input type="hidden" name="emp_id" value="<?= $id ?>" /><br>
        <input type="text" name="co_contents">
        <input type="submit" value="저장">
    </form>
    <br>

    <!-- 2. 댓글 Read 영역 생성  -->
    <!-- 조건: detailview의 emp_id을 가진 댓글만 불러옴 -->
    <div class="comment_view">
<?php
    $sql = "SELECT * FROM comment WHERE emp_id =".$id;
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
?>
    <div class="comment_box">
    <!-- 평소에 보여질 코멘트 부분 -->
        <div class="each_comment">
        <p><?= $row['co_writer'] ?>&nbsp;<?= $row['co_date']?>&nbsp;</p>
        <p><?= $row['co_contents']?></p>
        </div>
    <!-- 코멘트의 수정, 삭제버튼 -->
        <div class="comment_buttons">
        <a href="commentDeleteProcess.php?co_id=<?= $row['co_id'] ?>&emp_id=<?= $id ?>">삭제</a>
        <button class="accordion">수정</button>&nbsp;&nbsp;
    <!-- 수정버튼을 누르면 보여질 코멘트 수정 부분 -->
    <!-- 3. 댓글 영역 수정하기 -->
        <form action="commentUpdateProcess.php" method="POST" class="coUpdateForm" id="close">
            <input type="hidden" name="co_id" value="<?= $row['co_id'] ?>" />
            <input type="hidden" name="emp_id" value="<?= $row['emp_id'] ?>" />
            <input type="text" name="co_writer" value="<?= $row['co_writer']?>" readonly/>
            <input type="text" name="co_contents" value="<?= $row['co_contents'] ?>" />
            <input type="submit" value="저장">
            <input type="button" value="취소" onclick="myclose()" />
        </form>
        </div>
    </div>


    </div>
<?php
}
    // 4. 리소스 반납.
    $result->close();
    $conn->close();
?>
    </div>
<script>
    let acc = document.getElementsByClassName("accordion");
    let i;
// classList는 class를 제어자로 toggle add remove 
    for(i = 0; i < acc.length; i++ ){
        acc[i].addEventListener("click", function(){
            this.classList.toggle("active");
        
        let target = this.nextElementSibling;
            if (target.style.display == "block"){
                target.style.display = "none"
            }else{
                target.style.display = "block"
            }
        })
    }
// 클로즈 함수 쓰는거 알아두기. 함수 이름을 쓸 때는 전역메서드로 있을법한 이름은 지양하자.
    
    function myclose() {
        let x = document.getElementById("close");
        x.style.display = "none";
    }

</script>
</body>
</html>