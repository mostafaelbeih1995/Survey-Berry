<?php 
session_start();
	//get survey link from the url
$surveyLink = "" ;
$id_arr = array();
$survey_id = 0 ;
$title = "" ;
$surveyLink = "" ;
$permission = "" ;
require("../db/sqlcheck.php"); 
if (isset($_GET["link"])) {
	$surveyLink = $_GET["link"] ;
} 

//Check if user has permission for the user to answer the survey
//-----------------------------------------------------------------------------------
$query = "SELECT SURVEYTYPEID,SURVEYID FROM survey WHERE LINKSTRING = '$surveyLink'" ;
$stmt = queryDB($query);
$result = fetch($stmt);
$survey_id = $result[1];

	//check if someone is sign in before answering the survey
if($result[0] == 2) {
		//check if a user is signed in
	if (!isset($_SESSION["name"]) && !isset($_SESSION["email"]) ) {
		header("location:errors.php?locked=forusersonly"); 
	} 
	 //get UserID 
	else {
		$user_email = $_SESSION["email"];
		$query = "SELECT USERID FROM user WHERE EMAIL = '$user_email'" ;
		$stmt = queryDB($query);
		$result = fetch($stmt);
		$userid = $result[0] ;
		$_SESSION["userid"] = $userid ;
	//check if user id has the right permission id in the database table
		$query1 = "SELECT PERMISSIONID FROM survey_permissions WHERE EMAIL = '$user_email' AND SURVEYID = $survey_id " ;
		$stmt1 = queryDB($query1);
		$number_of_rows1 = $stmt1->rowCount();
		if($number_of_rows1 > 0 ){
			$result1 = fetch($stmt1)[0];
			if( $result1 == 3 && $number_of_rows1 > 0 ){
				$permission = "" ;
			}
			else if($result1 == 2 && $number_of_rows1 > 0 ){
				$permission = "disabled" ;
			}	
		}
		else {
			$permission = "restrict" ;
			header("location:errors.php?locked=restricted"); 
		}
	}
}
//--------------------------------------------------------

	//check if survey link exists in the database
$query = "SELECT TITLE,DATECREATED,LINKSTRING,SURVEYID FROM survey WHERE LINKSTRING = '$surveyLink'" ;
$stmt = queryDB($query);
$number_of_rows = getRowCount($stmt);
$result = fetch($stmt);
	if($number_of_rows > 0){ // row found login
		$title = $result [0];
		$dbdate = $result [1];
		$survey_id = $result[3];
	}
	else {
		header("location:../index.php?msg=Survey not found"); 
	}

	//get ip for the one who openend this page
	function getIp() {
		$ip = $_SERVER['REMOTE_ADDR'];

		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		return $ip;
	}?>
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
		<link rel = "icon" href = "../images/raspberry.png">
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
		<script src="../myscript.js" type="text/javascript"></script>
		<script src="../jquery-3.1.1.js"></script>
		<style type="text/css">
		</style>
	</head>
	<body>
		<div class = "logo-title links">
		<h1><a href = "../index.php">SurveyBerry <img src = "../images/raspberry.png"> </a></h1>
	</div>
		<?php 
			 if (!empty($_SESSION['missing'])){
		?>
		<div id="man-missing"> Please fill or answer all required (*) questions  </div>
		<?php 
		unset($_SESSION['missing']); // return it to null
		} ?>
		<div class="survey-content-container"> 
			<div class="q-container">
				<div class="titlecheck">
					<h3> <?= $title ?> <h3>
					</div>
					<form method="post" action="survey_submitted.php?link=<?=$surveyLink ?>"  > 
						<div class="survey-questions">
							<?php
							$query = "SELECT QUESTIONID,TITLE,QUESTIONTYPEID,CONTENTS,OPTIONAL FROM question WHERE SURVEYID = '$survey_id'"; 
							$qr_data = queryDB($query);
							$data = fetchAll($qr_data);
							$counter = 0 ;
							$data1 = getRowCount($stmt);

					//taking data and adding them to the html page
							foreach($data as $row) {
								$q_id = $row['QUESTIONID'];
								$qt_string = $row['TITLE'];
								$type = $row['QUESTIONTYPEID'] ;
								$field= $row['CONTENTS'];
								$optional = $row['OPTIONAL'];
								//adding question ids to the array
								$id_arr[$counter] = $q_id ;
								$counter++;
	    						//text field type
								if($type == 1 ){ 
									if($optional)
										echo "<p></br> $qt_string  </p> " ;
									else 
										echo "<p></br> $qt_string * </p> " ;
									?>    						
									<input type="text" id="textArea" name=<?=$q_id ?>  <?= $permission?> >
									<br> <br>
									<?php
								}
						//Multiple choice type
								if($type == 2 ){
									if($optional)
										echo "<p></br> $qt_string  </p> " ;
									else 
										echo "<p></br> $qt_string * </p> " ;
									$choices = explode(";",$field);
									$arr_size  = sizeof($choices);	
									for($i = 0 ; $i < $arr_size ; $i++){
										?>
										<input type="radio" name=<?=$q_id ?> value=<?=$choices[$i]?>  <?= $permission?> > <?=$choices[$i]?> <br>
										<?php
									}
								}

								//if type equal to a likert 
								if($type  == 3 ){
									?>
									<div class="wrap">
											<label class="statement"><?=$qt_string?></label>
											<ul class='likert'>
												<li>
													<input type="radio" name= <?=$q_id ?> value="Strongly Agree">
													<label>Strongly agree</label>
												</li>
												<li>
													<input type="radio" name= <?=$q_id ?> value="Agree">
													<label>Agree</label>
												</li>
												<li>
													<input type="radio"name= <?=$q_id ?> value="Neutral">
													<label>Neutral</label>
												</li>
												<li>
													<input type="radio" name= <?=$q_id ?> value="Disagree">
													<label>Disagree</label>
												</li>
												<li>
													<input type="radio" name="likert" value="Strongly Disagree">
													<label>Strongly disagree</label>
												</li>
											</ul>
										
											</div>
											<?php

										}	



								if($type == 4 ){ //True false question
									if($optional)
										echo "<p></br> $qt_string  </p> " ;
									else 
										echo "<p></br> $qt_string * </p> " ;
									?>
									<input <?= $permission?> type="radio" checked="checked" name=<?=$q_id ?> value="True"> Yes<br>
									<input <?= $permission?> type="radio" name=<?=$q_id ?> value="False">  No<br>
									<?php
								}
							}
							$_SESSION["idarray"] = $id_arr ;
							$_SESSION["addrr"] = getIp() ;
							$_SESSION["surveyid"] = $survey_id ;
							?>
						</div>	
						<div id="clear-div"></div>
						<div class="sub-bttn">
							<input <?= $permission?> type="submit" value="Submit">
						</div>
					</form>		

				</div>

			</div>
		</body>

		</html>