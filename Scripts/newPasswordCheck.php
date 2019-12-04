<?php
  require("db/sqlcheck.php");
  session_start();
  if(empty($_POST["user_new_password"]) || empty($_POST["user_con_new_password"])){
    $_SESSION["newPassword_full"] = "false";
    header("location:newPassword.php");
  }

  else{           // means that both of the fields are set(have info)
      $user_id  = $_SESSION["id"];
      $query = "SELECT * FROM user WHERE USERID = '$user_id'";
      $stmt = $Database->prepare($query);
      $stmt->execute();
      $user = $stmt->fetch();
      $user_hashcode = $user["HASHCODE"]; //get hash code
      $username = $user["USERNAME"];      // get name
      $user_email = $user["EMAIL"];       // get email
      $_SESSION["old_password"] = $user_hashcode; //save hashcode in the session
      $_SESSION["name"] = $username;              //save name in the session
      $_SESSION["email"] = $user_email;           // same for email

    if(isset($_POST["user_new_password"]) && isset($_POST["user_con_new_password"])){
      // saving values from post to new variables
      $user_new_password = $_POST["user_new_password"];
      $user_con_new_password = $_POST["user_con_new_password"];
      $user_hashcode = $_SESSION["old_password"];
      $password_bool = password_verify($user_new_password,$user_hashcode);
      ////////////////////////////////////////////////////////////////////////



      if($password_bool){// same old password
        $_SESSION["sameOldPassword"] = "false"; // an indicator we have the same old password
        header("location:newPassword.php");
      }
      else if($user_new_password != $user_con_new_password){
          $_SESSION["confirmPassword"] = "false"; // confirmation doesn't match new password
          header("location:newPassword.php"); 
      }
      else if(!empty($_POST["user_new_password"]) && !empty($_POST["user_con_new_password"])){
        // update it in the database and move to profile
        $user_new_password = password_hash($user_new_password, PASSWORD_DEFAULT);
          $query = "UPDATE user SET HASHCODE = '$user_new_password' 
          WHERE USERID = '$user_id'";
          $stmt = $Database->prepare($query);
          $stmt->execute();
          header("location:profile/profile.php?restore=true");  
      }

    }
  }
  
?>