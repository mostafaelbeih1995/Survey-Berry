<?php
require("../db/sqlcheck.php");
session_start();

$user_username = $_SESSION["name"] ;

$user_email = $_SESSION["email"]   ;

// print "$user_username";
$query = "SELECT HASHCODE FROM user WHERE EMAIL = '$user_email'";
$stmt = $Database->prepare($query);
$stmt->execute();
$password = $stmt->fetch();
$password = $password[0];
  if(!empty($_POST["user_old_password"]) && !empty($_POST["user_new_password"]) && !empty($_POST["user_con_new_password"])){
    $user_old_password = $_POST["user_old_password"];
    $user_new_password = $_POST["user_new_password"];
    $user_con_new_password = $_POST["user_con_new_password"];
    $password_bool = password_verify($user_old_password,$password);
    if(!$password_bool){
      ?>
      <script type = "text/javascript">
      alert("You typed the wrong old pasFsword");
    </script>
    <?php
    }
    else if($user_old_password == $user_new_password){
       ?>
    <script type = "text/javascript">
      alert("can't choose same old password");
    </script>
    <?php
      // add a pop up javascript thing here
    }
    else if($user_new_password != $user_con_new_password){
      ?>
    <script type = "text/javascript">
      alert("confirm the password correctly");
    </script>
    <?php
      // add a pop up javascript thing here
      // header("location:change_psswd.php");
    }
    else{
      $user_new_password = password_hash($user_new_password, PASSWORD_DEFAULT);
      $query = "UPDATE user SET HASHCODE = '$user_new_password' WHERE EMAIL = '$user_email'";
      $stmt = $Database->prepare($query);
      $stmt->execute();
      header("location:profile.php");
    }
  }
  else{  
  }
?>
<html>

  <head>

    <title>

        SurveyBerry

    </title>

      <meta charset="UTF-8">

      <meta name="viewport"

            content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

      <meta http-equiv="X-UA-Compatible" content="ie=edge">

      <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

      <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">

      <link rel="stylesheet" type="text/css" href="../css/mystyle.css">

      <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
      <link rel = "icon" href = "../images/raspberry.png">
      <script src="../myscript.js" type="text/javascript"></script>

      <script src="jquery-3.1.1.js"></script>



 </head>

 <body>

   <div class = "logo-title links">

            <h1><a href = "../index.php">SurveyBerry <img src = "../images/raspberry.png"></a></h1>

      </div>

      <div class = "container">
        <div class = "main">
          <div class = "row">
            <div class = "col-md-4 col-md-offset-4">
              <h2>Reset Your Password</h2>
              <div class = "login">

                    <form action="change_psswd.php" method="post">


                      <div class="form-group">

                        <input type="password" class="form-control" id="old_pwd" name = "user_old_password" placeholder="Type Old Password">

                      </div>

                      <div class="form-group">

                        <input type="password" class="form-control" id="new_pwd" name = "user_new_password" placeholder="New Password">

                      </div>

                      <div class="form-group">

                        <input type="password" class="form-control" id="new_con_pwd" name = "user_con_new_password" placeholder="Confirm New Password">

                      </div>

                      <div class = "col-md-8 col-md-offset-3">
                      <button type = "submit" class = btn-customize-index>Reset Password</button>
                    </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
  </div>

 </body>

  </html>