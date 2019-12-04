<?php
  require("db/sqlcheck.php");
  session_start();
  $password = $_POST["user_new_password"];
  $con_password = $_POST["user_con_new_password"];
  $id = $_SESSION["id"];
  $query = "SELECT * FROM user WHERE USERID = '$id'";
  $stmt = $Database->prepare($query);
  $stmt->execute();
  $user = $stmt->fetch();
  print_r($user);
  if($password == $con_password){
    $query = "UPDATE user SET HASHCODE = '$password' WHERE USERID = '$id'";
    $stmt = $Database->prepare($query);
    $stmt->execute();
    header("location:profile/profile.php");
    print_r($id);
    print_r("<br>");
    print_r("password should have changed");
  }
  else{
    header("location:authenticate.php");
    print_r("<br>");
    print_r("wrong info");
  }
?>