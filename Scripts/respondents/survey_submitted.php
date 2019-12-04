	<?php
	session_start();
	if (isset($_SESSION["idarray"]) && isset($_SESSION["addrr"]) && isset($_SESSION["surveyid"]) )
	{
		$id_array = $_SESSION["idarray"];
		$ip =  $_SESSION["addrr"] ;
		$survey_id =$_SESSION["surveyid"];
	}
	else {
		session_destroy();
		header("location:../index.php"); 
	}
	$link_survey = "";
	if (isset($_GET["link"])) {
		$link_survey = $_GET["link"] ;
	} 
	require("../db/sqlcheck.php");
	//check if answered all non-optional answers
	$check_optional = true ;
	//Inserting responses to each question into the database
	for($i = 0 ; $i < sizeof($id_array);$i++){
		$qid = $id_array[$i] ;
		$optional_query  = "SELECT OPTIONAL FROM question WHERE QUESTIONID = $qid " ;
		$qstmt = queryDB($optional_query);
		$optional_data = fetch($qstmt);
		$optionalValue = $optional_data[0]; // here we get the optional value for the questions
		$response_answer = $_POST[$qid];
		if(!isset($_POST[$qid]) && $optionalValue == false || trim($response_answer) =='') {
			$check_optional = false ;
			$_SESSION['missing'] = 'false';
			header('Location:survey.php?link='. $link_survey);
			
		}
	}
	if($check_optional){
	//Check survey type 
		$querysurvey = "SELECT SURVEYTYPEID FROM survey WHERE SURVEYID = '$survey_id '" ;
		$stmt = queryDB($querysurvey);
		$result = fetch($stmt);
		if ($result[0] == 1){ //if anonymous survey
			$queryinsert  = "INSERT INTO respondent VALUES(0,NULL);";
			$stmt = queryDB($queryinsert);
		}
		else { //if specific users survey
			//get user id and insert it here
			$userid = $_SESSION["userid"];
			$queryinsert  = "INSERT INTO respondent VALUES(0,'$userid');";
			$stmt = queryDB($queryinsert);
		}
		//get max response ID
		$query = "SELECT MAX(RESPONDENTID) FROM respondent ;" ;
		$stmt = queryDB($query);
		$respID = fetch($stmt)[0] ;
		for($i = 0 ; $i < sizeof($id_array);$i++){
			$qid = $id_array[$i];
			$response_answer = $_POST[$qid];
			$query1 = "INSERT INTO response VALUES(0,'$qid','$response_answer','$respID') ;"; 
			$stmt = queryDB($query1);
		}
			//add a new response to the survey
		$query = " UPDATE survey SET RESPONSES = RESPONSES + 1 WHERE LINKSTRING = '$link_survey' " ;
		$stmt = queryDB($query);
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
		<link rel = "icon" href = "../images/raspberry.png">
		<link rel="stylesheet" type="text/css" href="../css/mystyle.css">
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
		<script src="../myscript.js" type="text/javascript"></script>
		<script src="../jquery-3.1.1.js"></script>
	</head>
	<body>
		<div class = "logo-title">
			<h1>SurveyBerry <img src = "../images/raspberry.png"></h1>
		</div>
		<div class="result-submit">
			<h1> Survey Submitted Successfully</h1>
			if you would like to sign up to our website, <a href="../index.php">click this link</a>
			<script type="text/javascript">setTimeout("window.close();", 5000);</script>
		</div>
	</body>

	</html>