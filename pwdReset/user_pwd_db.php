<?php
require_once "../util/dbconfig.php";

//post 혹은 get방식으로 form에서 데이터를 받아 올 때, 이를 악의적으로 사용하는 사용자를 방지하기 위해 잘못된 문자열을 제거하고 이메일형식이 맞는지 확인해준다 (정규식표현 처럼)
if (isset($_POST["email"]) && (!empty($_POST["email"]))) {
    $email = $_POST["email"];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    // filter_var($email,FILTER_SANITIZE_EMAIL): 입력받은 이메일에서 잘못된 문자를 제거함.
    //filter_var($email,FILTER_VALIDATE_EMAIL) : 입력받은 이메일이 이메일 주소형식에 맞게 입력됬는지 확인하는 함수. true, false 타입으로 반환함

    if(!$email){
        $error ="<p>올바른 이메일 주소를 작성해 주세요</p>";
    }else{
        $sel_query = "SELECT * FROM `users` WHERE email ='" .$email ."'";
        $results = mysqli_query($conn,$sel_query);
        $row = mysqli_num_rows($results);
        if($row ==""){
            $error = "<p>등록되지 않은 이메일 입니다.</p>";
        }
    }if ($error != "") {?>
        <div class='error'>
            <?= $error ?></div>
        <br><a href = 'javascript:history.back(-1)'>Go Back</a>
    <?php
    //이메일 형식도 올바르고, 이미 등록된 이메일이면,
    }else{
        // 유효기간 설정
        $expFormat = mktime(
            date("H"), date("i"), date("s"), date("m"), date("d")+1, date("Y")
        );
        $expDate = date("Y-m-d H:i:s", $expFormat);
        // 암호 설정
        $key = md5($expDate+$email);
        $addkey = substr(md5(uniqid(rand(),1)),3,10);
        $key = $key . $addkey;
    }
    //테이블에 키를 집어 넣음
    mysqli_query($conn,
    "INSERT INTO `password_reset_temp` (`email`, `key`, `expDate`)
    VALUES('".$email."', '".$key."', '" .$expDate."');");
// --여기부터 내맘대로 건든거 --
    $rsuser = "SELECT `username` From `users` WHERE email ='" .$email ."'";
    $rsresults = mysqli_query($conn, $rsuser);
    $rsrow = mysqli_num_rows($rsresults);

    $output = "<p> Dear ".$rsrow.",</p>";
// -- 안되면 여기까지 수정하자 --
    $output.= "<p>Please click on the following link to reset your password.</p><br>";
    $output.= '<p><a href="https://www.allphptricks.com/forgot-password/reset-password.php?
    key='.$key.'&email='.$email.'&action=reset" target="_blank">Password Recovery</a></p><br>';
    $output.='<p>The link will expire after 1 day for security reason.</p>
    <p>If you did not request this forgotten password email, no action is needed, your password will not be reset. However, you may want to log into your account and change your security password as someone may have guessed it.</p>
    <p>Thanks.</p>';
    $body = $output;
    $subject = "Password Recovery";

    $email_to = $email;
    $fromserver = "noreply@jellyshot.com";
    require("PHPMailer/PHPMailerAutoload.php");
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Host = "mail.jellyshot.com"; 
    $mail->SMTPAuth = true;
    $mail->Username = "noreply@jellyshot.com";
    $mail->Password = "";
    $mail->Port = 25;
    $mail->IsHTML(true);
    $mail->From = "noreply@jellyshot.com";
    $mail->FromName = "AllPHPTricks";
    $mail->Sender = $fromserver; 
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->AddAddress($email_to);

    if(!$mail->Send()){
        echo "Mailer Error: " . $mail->ErrorInfo;
        }else{
        echo "<div class='error'>
        <p>An email has been sent to you with instructions on how to reset your password.</p>
        </div><br><br><br>";
        }
}else{
?>
    <form method="post" action="" name="reset"><br /><br />
    <label><strong>Enter Your Email Address:</strong></label><br><br>
    <input type="email" name="email" placeholder="username@email.com" /><br><br>
    <input type="submit" value="Reset Password"/>
    </form>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
<?php
}
?>



