<!----------------------------------------------------------------------------- 
  파일명 : autility.php
  최초작성자 : swcodingschool
  최초작성일 : 2021-12-30
  업데이트일 : 2022-01-03
  
  기능: 
  DBMS 시스템 접속용 기본 정보 선언.
  실제 애플리케이션 제작에서는 클라이언트 사이트의 환경,
  즉, DBMS의 종류별 configuration 정보를 참조하여 구성함.
------------------------------------------------------------------------------>

<?php
// 개발단계 디버그 모드 
const DBG = TRUE;  // 개발 중 DBG 모드일 때 TRUE, 운영 시 FALSE로 토글시킨다

// 메시지 출력을 위한 const 선언
// 시스템 초기화시 사용 메시지
const DBCONN_SUCCESS = '데이터베이스 연결에 성공하였습니다.';
const DBCONN_FAIL = '데이터베이스 연결에 실패하였습니다.\n초기화 작업을 종료합니다.';
const DROPDB_SUCCESS = '기존 데이터베이스를 성공적으로 삭제하였습니다.';
const DROPDB_FAIL = '기존 데이터베이스 삭제에 실패하였습니다.';
const DROPUSER_SUCCESS = '기존 애플리케이션용 계정을 성공적으로 삭제하였습니다.';
const DROPUSER_FAIL = '기존 애플리케이션용 계정 삭제에 실패하였습니다.';
const CREATEDB_SUCCESS = '데이터베이스를 성공적으로 생성하였습니다.';
const CREATEDB_FAIL = '데이터베이스 생성에 실패하였습니다.';
const CREATEUSER_SUCCESS = '애플리케이션용 계정을 성공적으로 생성하였습니다.';
const CREATEUSER_FAIL = '애플리케이션용 계정 생성에 실패하였습니다.';
const LIMITRSC_SUCCESS = '리소스 제한을 성공적으로 처리하였습니다.';
const LIMITRSC_FAIL = '리소스 제한을 처리에 실패하였습니다.';
const GRANTUSER_SUCCESS = '데이터베이스에 대한 권한부여에 성공하였습니다.';
const GRANTUSER_FAIL = '데이터베이스에 대한 권한부여에 실패하였습니다.';
const CREATETBL_SUCCESS = '테이블을 성공적으로 생성하였습니다.';
const CREATETBL_FAIL = '테이블 생성에 실패하였습니다.';
const DROPTBL_SUCCESS = '기존 테이블을 성공적으로 삭제하였습니다.';
const DROPTBL_FAIL = '기존 테이블 삭제에 실패하였습니다.';
const INSERT_SUCCESS = '데이터를 성공적으로 추가하였습니다.';
const INSERT_FAIL = '데이터 추가에 실패하였습니다.';
const SELECT_SUCCESS = '데이터를 성공적으로 조회하였습니다.';
const SELECT_FAIL = '데이터 조회에 실패하였습니다.';
const UPDATE_SUCCESS = '데이터를 성공적으로 갱신하였습니다.';
const UPDATE_FAIL = '데이터 갱신에 실패하였습니다.';
const INVALID_USER = '수정하고자 하는 사용자 계정을 한번 더 확인해주세요 ';
const DELETE_SUCCESS = '데이터를 성공적으로 삭제하였습니다.';
const DELETE_FAIL = '데이터 삭제에 실패하였습니다.';
const COMMIT_CODE = '코드를 모두 실행하였습니다.\n이전 페이지로 돌아갑니다.';
const PWD_RESET_SUCCESS = '비밀번호 초기화에 성공했습니다.';
const PWD_RESET_FAIL = '비밀번호 초기화에 실패했습니다.';
const INVALID_MEMOID = '존재하지 않는 페이지 입니다.';


// form validation 시 사용 메시지
const FILL_USERNAME = '사용자 아이디를 적어주세요.';
const FILL_PASSWD = '비밀번호를 적어주세요.';
const FILL_CPASSWD = '비밀번호(확인)을 적어주세요.';
const FILL_CELLPHONE = '전화번호를 적어주세요.';
const FILL_EMAIL = '이메일주소를 적어주세요.';
const DIFF_PASSWD = '비밀번호가 확인용 비밀번호와 다릅니다.';
const EXIST_USERNAME = '존재하는 아이디입니다.';

// 로그인 성공 삭제
const LOGIN_SUCCESS = '로그인에 성공하였습니다.';
const LOGIN_FAIL = '로그인에 실패하였습니다.';

// 코멘트 작성 성공 실패
const COMMENT_SUCCESS = '댓글이 정상적으로 작성되었습니다.';
const COMMENT_FAIL = '댓글 작성에 실패하였습니다.';

//파일 이동 성공 실패
const UPLOAD_SUCCESS = '파일이 정상적으로 업로드 되었습니다.';
const UPLOAD_FAIL = '파일 업로드에 실패했습니다.';

// SESSION 관리
const SESSION_START = '로그인 관리를 위한 세션관리를 시작하였습니다.';
const SESSION_CREATE = '세션 변수를 생성하였습니다.';
const SESSION_DELETE = '로그인 관리를 종료하고 세션을 삭제하였습니다.';
const LOGIN_NEED = '로그인이 필요한 페이지입니다.';



// 팝업창 형태의 알림 메시지 출력용 함수 정의
function outmsg($msg)
{
    return "<script>alert('" . $msg . "')</script>";
}

/* 사용자 ip를 가져오는 함수 생성
 session관리를 할 때, 가장 심플한 방법은 username을 세션으로 만들고 체크하는 것 이지만, 위험에 노출될 확률이 높아지므로 '사용자 이름', '비밀번호', '사용자의 IP', 를 하나의 변수로 만들어 이 묶음을 session으로 준다. 
 따라서 쌤이 나중이 클라이언트 ip도 session에 넣어보라고 만들어두심 */

function get_client_ip()
{
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
?>