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
    <h1>인사정보 입력 화면</h1>
    <form action="insertprocess.php" method="POST">
        <label for="emp_name">성명</label>
        <input type="text" name="emp_name"/><br>
        <label for="emp_number">사원번호</label>
        <input type="text" name="emp_num"/><br>
        <label for="emp_name">전화번호</label>
        <input type="tell" name="emp_phone"/><br>
        <label for="emp_name">채용일자</label>
        <input type="date" name="emp_hiredate"/><br>
        <label for="emp_name">부서코드</label>
        <input type="number" name="emp_deptcode"/><br>
        <label for="emp_name">주소</label>
        <input type="text" name="emp_address"/><br>
        <label for="emp_name">이메일</label>
        <input type="email" name="emp_email"/><br>
        <input type="submit" value="저장">
    </form>
</body>
</html>