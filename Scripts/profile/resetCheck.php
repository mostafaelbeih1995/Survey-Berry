<?php
	require("../db/sqlcheck.php");
	if(empty($_POST["user_email"]) || empty($_POST["dob"]) || empty($_POST["answer1"]) || empty($_POST["answer2"])){
    print_r("Some fields are empty");
  	}
  	$user_email = $_POST["user_email"];
  	$dob = $_POST["dob"];
  	$answer1 = $_POST["answer1"];
  	$answer2 = $_POST["answer2"];
  	$question1 = $_POST["security_question_one"];
  	$question2 = $_POST["security_question_two"];
  	$query = "SELECT * FROM user WHERE EMAIL = '$user_email'";
  	$stmt = $Database->prepare($query);
	$stmt->execute();
	$user = $stmt->fetch();
	print_r($user);
	print_r("<br>");
	$user_id = $user['userid'];
	// print_r("<br>");
	// print_r($user_id);
	$query = "SELECT * FROM user_security WHERE userid = '$user_id'";
	$stmt = $Database->prepare($query);
	$stmt->execute();
	$user_security = $stmt->fetch();
	// print_r("<br>");
	print_r($user_security);
	$user_dob = $user_security['date_of_birth'];
	$user_question1 = $user_security['question1'];
	$user_question2 = $user_security['question2'];
	$user_answer1 = $user_security['answer1'];
	$user_answer2 = $user_security['answer2'];
	print_r("USer dob is :");
	print_r($user_dob);
	print_r("<br>");
	print_r("saved dob is :");
	print_r($dob);
	print_r("<br>");
	if(($dob == $user_dob) && ($question1 == $user_question1) && ($question2 == $user_question2) &&
		($answer1 == $user_answer1) && ($answer2 == $user_answer2)){
		session_start();
		$_SESSION["id"] = $user_id;
		
		header("location:newPassword.php");		
	}
	else{
		print_r("Wrong information");
		// header("location:../signup.php");
	}
?>