<?php
	require("db/sqlcheck.php");
	if(empty($_POST["user_email"]) || empty($_POST["dob"]) || empty($_POST["answer1"]) || empty($_POST["answer2"])){
    	session_start();
    	$_SESSION['full'] = "false";
    	header("location:reset.php");
  	}
  	else{
	  	$user_email = $_POST["user_email"];
	  	$dob = $_POST["dob"];
	  	$answer1 = $_POST["answer1"];
	  	$answer2 = $_POST["answer2"];
	  	$question1 = $_POST["security_question_one"];
	  	$question2 = $_POST["security_question_two"];



	  	
	  	//getting user id to check if everything inside user and user_security is correct
	  	$query = "SELECT * FROM user WHERE EMAIL = '$user_email'";
	  	$stmt = $Database->prepare($query);
		$stmt->execute();
		$user = $stmt->fetch();
		$user_id = $user['USERID'];
		$query = "SELECT * FROM user_security WHERE userid = '$user_id'";
		$stmt = $Database->prepare($query);
		$stmt->execute();
		$user_security = $stmt->fetch();
		$user_dob = $user_security['dateofbirth'];
		$user_question1 = $user_security['question1'];
		$user_question2 = $user_security['question2'];
		$user_answer1 = $user_security['answer1'];
		$user_answer2 = $user_security['answer2'];
		if(($dob == $user_dob) && ($question1 == $user_question1) && ($question2 == $user_question2) &&
			($answer1 == $user_answer1) && ($answer2 == $user_answer2)){
			session_start();
			$_SESSION["id"] = $user_id;
			header("location:newPassword.php");		
		}
		else{
			session_start();
			$_SESSION["wrong_info"] = "false";
			header("location:reset.php");
		}
}
?>