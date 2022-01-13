<!-- 
  파일명 : oo_user_updateprocess.php
  최초작업자 : swcodingschool
  최초작성일자 : 2021-12-28
  업데이트일자 : 2022-01-13
  
  기능: 
  oo_user_update.php 사용자 정보 수정 화면에서 입력된 값을 받아, 
  users 테이블에 사용자 수정된 데이터를 업데이트 한다.
-->

<?php
  // db연결 준비
  require "../util/dbconfig.php";
  require_once '../util/loginchk.php';

  $upload_path = './uploadfiles/';

  if($chk_login){
    // 데이터베이스 작업 전, 회원정보 수정 화면으로 부터 값을 전달 받고
    $id = $_POST['id'];
    $username = $_POST['username'];
    $title =  $_POST['title'];
    $contents = $_POST['contents'];
    
    if(isset($_FILES['uploadfiles']['tmp_name']) && ( $_FILES['uploadfiles']['tmp_name'] != "")) {
    //일단 파일 네임 정의해주고
    $filename = $_FILES['uploadfiles']['name'];
    //이름중복처리 방지
    $filename = time()."_".$_FILES['uploadfiles']['name'];
    
    //file이 정상적으로 업로드가 되어있으면, 기존 파일이 있는경우 삭제처리 하고 테이블에 추가하는 코드 작성.
    if(move_uploaded_file($_FILES['uploadfiles']['tmp_name'], $upload_path.$filename)){
                $sql="SELECT * FROM board WHERE id =" .$id ;
                $resultset = $conn->query($sql);
                $row = $resultset->fetch_assoc();
                // fatch_row: 인덱스에 따른 값이 불려옴
                // fatch_assoc: 열에 따른 값이 불려옴
                // fatch_array: 인덱스와 열에 따른 값이 불려옴.
                //해당 id의 'uploadfile' 열 값을 exixtingfile에 저장함
                $existingfile=$row['uploadfiles'];

                if(isset($existingfile) && $existingfile !=""){
                  unlink($upload_path.$existingfile); 
                  //파일이 있으면 지운다(unlink)
                }
      }
                // create connection
    // 업데이트 처리를 위한 prepared sql 구성 및 bind
    $stmt = $conn->prepare("UPDATE board SET title = ?, contents = ?, uploadfiles = ? WHERE id = ?" );
    $stmt->bind_param("sssi", $title, $contents, $filename, $id);
  }else {  // 업로드된 파일이 없을 때!!
   // 업데이트 처리를 위한 prepared sql 구성 및 bind
  $stmt = $conn->prepare("UPDATE board SET title = ?, contents = ? WHERE id = ?" );
  $stmt->bind_param("ssi", $title, $contents, $id); 
  }

  $stmt->execute();
  
  // 데이터베이스 연결 인터페이스 리소스를 반납한다.
  $conn->close();
  // 프로세스 플로우를 인덱스 페이지로 돌려준다.
  header('Location: ./detailview.php?id='.$id);

}else {
  echo outmsg(LOGIN_NEED);
  echo "<a href='../index.php'>인덱스 페이지로</a>";
}
?>