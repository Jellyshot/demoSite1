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
    $conn = new mysqli("localhost", "remind", "remind", "remind");
    $id = $_GET['id'];

    $sql = "SELECT * FROM employee WHERE id=".$id;
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
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
</body>
</html>