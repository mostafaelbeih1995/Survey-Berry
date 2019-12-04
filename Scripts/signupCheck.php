<?php 
require("db/sqlcheck.php");
session_start();
    if(empty($_POST["user_name"]) || empty($_POST["user_email"]) || empty($_POST["user_password"]) ||
        empty($_POST["user_con_password"]) ||  empty($_POST["answer1"]) || 
        empty($_POST["answer2"]) || empty($_POST["dob"])){
        $_SESSION["signupInfo"] = "false";
        header("location:signup.php");
    }
    else{
        // Assigning Variables


        $question1 = $_POST["security_question_one"];
        $question2 = $_POST["security_question_two"];
        $dob = $_POST["dob"];
        $answer1 = $_POST["answer1"];
        $answer2 = $_POST["answer2"];
        $user_name = $_POST["user_name"];  
        $user_email = $_POST["user_email"];
        $user_password = $_POST["user_password"];
        $user_con_password = $_POST["user_con_password"];

        // Making sure that user name and email is not recorded before



        // There is a bug here, I should remove the or username part and allow people to
        // choose usernames if they already exist but it has to be a unique email
        $checker = "SELECT * FROM user WHERE EMAIL = '$user_email'";
        $stmt = $Database->prepare($checker);
        $stmt->execute();
        $number_of_rows = $stmt->rowCount();

        if($number_of_rows == 0){ // no users before have the same user name or email
            if($user_password == $user_con_password){ // check if the user wrote the same password when he conformed it
              $user_password = password_hash($user_password, PASSWORD_DEFAULT);
              $user_con_password = $user_password;
              $query = "INSERT INTO `user` (`USERID`, `USERNAME`, `EMAIL`, `HASHCODE`) 
                VALUES (NULL, ' $user_name ', '$user_email', '$user_con_password');";
                $stmt = $Database->prepare($query);
                $stmt->execute();
                session_start();
                $user_id = $Database->lastInsertId();
                $_SESSION["email"] = $user_email;
                $_SESSION["name"] = $user_name;
                $_SESSION["question1"] = $question1;
                $_SESSION["answer1"] = $answer1;
                $_SESSION["question2"] = $question2;
                $_SESSION["answer2"] = $answer2;
                $_SESSION["dob"] = $dob;
                $_SESSION["id"] = $user_id;
                $fill_user_security = "INSERT INTO `user_security`(`userid`, `dateofbirth`, `question1`, `question2`, `answer1`, `answer2`)
                VALUES ($user_id,'$dob','$question1','$question2','$answer1','$answer2');";
                $stmt = $Database->prepare($fill_user_security);
                $stmt->execute();
                header("location:profile/profile.php?restore=false");
            }
            else{
              $_SESSION["signupPassword"] = "false";
              header("location:signup.php");
            }
        // 
          }
           else{
                $_SESSION["signupSameUserNameorEmail"] = "false";
                header("location:signup.php");
          }
    }
    
?>