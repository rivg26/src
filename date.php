<?php


// date_default_timezone_set('Asia/Hong_Kong');
// echo date('d M Y', strtotime(date('Y-m-d'))); 
// echo date('Y-m-d');

// Dateee Format

// $pwd = "admin123";
// $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
// echo $hashedPwd;

session_start();
echo $_SESSION['otpPhoneNumber'] .'<br>';
echo $_SESSION['otp'].'<br>';
echo $_SESSION['otpExpiration'].'<br>';
echo $_SESSION['username'].'<br>';
echo $_SESSION['forgotUsername'];

// echo !pwdvalidate('!Gregorio0226');

// function pwdvalidate($pwd){
// 	$pattern = "/[`'\"~!@# $*()<>,:;{}\|]/";
// 	if (strlen($pwd) <= 8) {
//         $pwdErr = true;
//     }
//     elseif(!preg_match("#[0-9]+#",$pwd)) {
//         $pwdErr = true;
//     }
//     elseif(!preg_match("#[A-Z]+#",$pwd)) {
//         $pwdErr = true;
//     }
//     elseif(!preg_match("#[a-z]+#",$pwd)) {
//         $pwdErr = true;
//     }
// 	elseif(!preg_match($pattern,$pwd)){
// 		$pwdErr = true;
// 	}
// 	else{
// 		$pwdErr = false;
// 	}
// 	return $pwdErr;
// }
?>