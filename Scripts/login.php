<?php
  session_start();
$user_email = $_POST["user_email"];
$user_password = $_POST["user_password"];
require('db/sqlcheck.php');	// for the connection
$stmt = queryDB("SELECT ".getUsernameColumn().",".getEmailColumn().",".getHashcodeColumn()." FROM user WHERE ".getEmailColumn()."= '$user_email' ;");
$number_of_rows = getRowCount($stmt);
$result = fetch($stmt);
$check_password = password_verify($user_password,$result[2]) ;	//
if($number_of_rows > 0   && $check_password){ // row found login
  $user_username = $result [0];
   $_SESSION["email"] = $user_email ;
   $_SESSION["name"] = $user_username;
   header("location:profile/profile.php");
}
else { //row not found and go back to login page
$_SESSION['valid'] = "false";
  header("location:index.php");
 }
?>