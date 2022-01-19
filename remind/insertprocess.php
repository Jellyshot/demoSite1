<?php
// insert.php에서 form으로 받아온 정보 변수처리해가

$emp_name = $_POST['emp_name'];
$emp_num = $_POST['emp_num'];
$emp_phone = $_POST['emp_phone'];
$emp_hiredate = $_POST['emp_hiredate'];
$emp_deptcode = $_POST['emp_deptcode'];
$emp_address = $_POST['emp_address'];
$emp_email = $_POST['emp_email'];

//데이터 베이스 연결
$hostname = 'localhost';
$username = 'remind';
$password = 'remind';
$dbname = 'remind';
$conn = new mysqli($hostname, $username, $password, $dbname);

//데이터 베이스 연결에 문제가 발생했을때 프로그램 정지 시키기.
if ($conn->connect_error) {
    die("데이터베이스 연결에 문제가 있습니다.").$conn->connect_error;
}

//데이터베이스 입력을 위한 sql구문 작성
//prepare statment 3종 셋트 $conn->prepare, bind_param, execute.
//prepare statment는 $sql이 아니라 $stmt로 사용한다.
$stmt = $conn->prepare("INSERT INTO employee(emp_name, emp_num, emp_phone, emp_hiredate, emp_deptcode, emp_address, emp_email) VALUES(?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssiss", $emp_name, $emp_num, $emp_phone, $emp_hiredate, $emp_deptcode, $emp_address, $emp_email );
$stmt->execute();

// 입력 완료 후 리소스 반납
$conn->close();
$stmt->close();

echo ("입력 성공");
header('Location: ./list.php');

?>