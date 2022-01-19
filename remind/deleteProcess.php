<?php
//데이터 베이스 연결 시키고
$conn = new mysqli('localhost', 'remind', 'remind', 'remind');

// detailview에서 넘어온 id값 써야하니까 지정해주고
$id = $_GET['id'];

$sql = "DELETE FROM employee WHERE id =".$id ;
$conn->query($sql);

header('Location: ./list.php')

?>