<?php
  session_start();
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

      <link rel="stylesheet" type="text/css" href="css/mystyle.css">

      <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
      <link rel = "icon" href = "images/raspberry.png">
      <script src="../myscript.js" type="text/javascript"></script>

      <script src="jquery-3.1.1.js"></script>



 </head>

 <body>

   <div class = "logo-title links">

            <h1><a href = "index.php">SurveyBerry <img src = "images/raspberry.png"></a></h1>

      </div>

      <div class = "container">
        <div class = "main">
          <div class = "row">
            <div class = "col-md-4 col-md-offset-4">
              <h2>Reset Your Password</h2>
              <div class = "login">

                    <form action="newPasswordCheck.php" method="post">

                    <?php if(!empty($_SESSION["sameOldPassword"])){?>

                      <div class="error-login">* can't choose same old password </div>
                    <?php }?>

                    <?php if(!empty($_SESSION["confirmPassword"])){?>

                      <div class="error-login">* confirm password correctly </div>
                    <?php }?>


                    <?php if(!empty($_SESSION["newPassword_full"])){?>

                      <div class="error-login">* fill the form completely </div>
                    <?php }?>
                      <div class="form-group">

                        <input type="password" class="form-control" id="new_pwd" name = "user_new_password" placeholder="New Password">

                      </div>

                      <div class="form-group">

                        <input type="password" class="form-control" id="new_con_pwd" name = "user_con_new_password" placeholder="Confirm New Password">

                      </div>

                      <div class = "col-md-8 col-md-offset-4">
                        <button type = "submit" class = btn-customize-index>Submit</button>
                      </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
  </div>
  <div class = "contact-us container-fluid">
    <div class = "row">
      <div class = "colm-md-12">
        Copyright © 2017 SurveyBerry
      </div>
    </div>
  </div>
 </body>

  </html>