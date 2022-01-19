<!-- CREATE를 위한 form화면 구성 -->

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
    // sql문을 쿼리한 값을 사용해야 함으로 result변수에 레코드를 담는다.
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();  
?>
    <h1>인사정보 수정 화면</h1>
    <!-- 입력화면과의 차이점은, 입력화면은 공란에서 새 레코드를 작성하지만, 수정은 기존값을 불러온 상태에서 수정작업이 들어간당 -->
    <form action="updateprocess.php" method="POST">
        <input type="hidden" name="id" value="<?= $row['id'] ?>" /><br>
        <label for="emp_name">성명</label>
        <input type="text" name="emp_name" value="<?=$row['emp_name'] ?>" readonly/><br>
        <label for="emp_num">사원번호</label>
        <input type="text" name="emp_num" value="<?=$row['emp_num'] ?>" readonly /><br>
        <label for="emp_phone">전화번호</label>
        <input type="tel" name="emp_phone" value="<?=$row['emp_phone'] ?>"/><br>
        <label for="emp_hiredate">입사일</label>
        <input type="date" name="emp_hiredate" value="<?=$row['emp_hiredate'] ?>" readonly/><br>
        <label for="emp_deptcode">부서코드</label>
        <input type="number" name="emp_deptcode" value="<?=$row['emp_deptcode'] ?>"/><br>
        <label for="emp_address">주소</label>
        <input type="text" name="emp_address" value="<?=$row['emp_address'] ?>"/><br>
        <label for="emp_email">이메일</label>
        <input type="email" name="emp_email" value="<?=$row['emp_email'] ?>"/><br>
        <input type="submit" value="저장">
    </form>
</body>
</html>