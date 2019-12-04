<?php
  require("db/sqlcheck.php");
  session_start();
  $user_id = $_SESSION["id"];
  $bool = false;  // bool to check something
  $password = $_POST["user_new_password"];
  $con_password = $_POST["user_con_new_password"];
  $id = $_SESSION["id"];
  $query = "SELECT * FROM user WHERE USERID = '$id'";
  $stmt = $Database->prepare($query);
  $stmt->execute();
  $user = $stmt->fetch();
  print_r($user);

  $query = "SELECT HASHCODE FROM user WHERE USERID = '$user_id'";  
  $stmt = $Database->prepare($query);
  $stmt->execute();
  $result = $stmt->fetch();
  $existing_password = $result["HASHCODE"];

  if($password == $con_password){
    if($existing_password !== $password){
      $query = "UPDATE user SET HASHCODE = '$password' WHERE USERID = '$id'";
      $stmt = $Database->prepare($query);
      $stmt->execute();
      $bool = true;
      $_SESSION["id"] = $user_id; 
      $_SESSION["existing_password"] = $existing_password;
      header("location:profile/profile.php?restore=true");
      // print_r($id);
      // print_r("<br>");
      // print_r("password should have changed");
    }
    else{
       $_SESSION["id"] = $user_id; 
      $_SESSION["existing_password"] = $existing_password;
      echo "<script type='text/javascript'>alert('Can't choose the same old password);</script>"; 
    }
  }
  else{
    echo "<script type='text/javascript'>alert('Confirm password right);</script>"; 
    header("location:newPassword.php");
  }
?>