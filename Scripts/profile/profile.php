<?php
session_start();
require("../db/sqlcheck.php");
//If a session does not exist and someone tries to access the php file


if (!isset($_SESSION["name"]) && !isset($_SESSION["email"]) ) {
	header("location:../index.php"); 
	session_destroy();
} 

if(isset($_SESSION["id"]) && isset($_GET["restore"]) &&  isset($_SESSION["existing_password"])) {
	$user_id = $_SESSION["id"];
	if($_GET["restore"] && $_GET["restore"] == true){
		$query = "SELECT ".getEmailColumn().",".getUsernameColumn()." FROM user WHERE ". getUserIDColumn() ." = '$user_id'";
		$result = fetch(queryDB($query));
		$user_email = $result["EMAIL"];
		$user_username = $result["USERNAME"];
	}
	else{
		$user_username = $_SESSION["name"] ;
		$user_email = $_SESSION["email"]   ;
	}
	$existing_password = $_SESSION["existing_password"];
}
else {
	$user_username = $_SESSION["name"] ;
	$user_email = $_SESSION["email"] ;
	$query = "SELECT USERID FROM user WHERE EMAIL = '$user_email'";
	$userid = fetch(queryDB($query))[0];
}

$surveyID = 0 ;
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
	<script src="../myscript.js" type="text/javascript"></script>
	<link rel = "icon" href = "../images/raspberry.png">
	<link rel="stylesheet" href="../css/reveal.css">
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.6.min.js"></script>
	<script type="text/javascript" src="../jquery.reveal.js"></script>
</head>
<body>
	<div class = "logo-title links">
		<h1><a href = "../index.php">SurveyBerry <img src = "../images/raspberry.png"> </a></h1>
	</div>
	<div class = "container">
		<div class = "user-info">
			<div class = "row">
				<div class = "col-md-1">
					<img src = "../images/user.png">
				</div>
				<div class = "col-md-3">
					<div class = "row">
						<?=   
						$user_username 
						?>
					</div>
					<form id="my_form" class = "row" action="logout.php" method="post">
						<a href="javascript:{}" onclick="document.getElementById('chps').submit(); return false;">Change Password</a><br>
						<a href="javascript:{}" onclick="document.getElementById('my_form').submit(); return false;">Sign out</a> 
					</form>
				</div>
				<div class = "col-md-3 col-md-offset-5">
					<div id="Download-div" class = "btn-download">
						<a id="download-link" href="../Software/Sberry.zip" target="_blank">Download Sberry</a>
					</div>
				</div>
			</div>
		</div>
		<a href="#" id="animation" class="big-link" data-reveal-id="myModal"></a>
		<?php
		//notification if a survey was deleted 
		if (isset($_GET["deleteStatus"])) {
			$deleteStatus= $_GET["deleteStatus"] ;
			if($deleteStatus == "success"){
				?>
				<div id="myModal" class="reveal-modal">
					<h1>Survey has been Deleted</h1>
					<a class="close-reveal-modal">&#215;</a>
				</div>
				<script type="text/javascript">
					document.getElementById('animation').click();
					window.location.href = "profile.php";
				</script>
				<?php
				
			}
			//error on survey delete
			else{ 
				?>
				<div id="myModal" class="reveal-modal">
					<h1>  &nbsp &nbsp &nbspError Occurred </h1>
					<a class="close-reveal-modal">&#215;</a>
				</div>					
				<script type="text/javascript">
					document.getElementById('animation').click();
				</script>
				<?php
			}
		} 
        // getting data from database for surveys for the user
		$stmt = queryDB("SELECT  TITLE,DATECREATED,LINKSTRING, SURVEYID,RESPONSES,SURVEYTYPEID  FROM survey WHERE CREATEDBYUSERID = '$userid' ");
		$data1 =getRowCount($stmt);
		$data = fetchAll($stmt);
		if($data1 > 0 ) {
		 	 foreach($data as $row) { // row found login
		 	 	$survey_title = $row ['TITLE'];
		 	 	$survey_date = $row ['DATECREATED'];
		 	 	$survey_link = "../respondents/survey.php?link=". $row ['LINKSTRING'];
		 	 	$surveyID = $row ['SURVEYID'];		 	 
		 	 	$linknum = $row ['LINKSTRING'] ;
		 	 	$responses_num = $row ['RESPONSES'] ."";
		 	 	$typeID = $row ['SURVEYTYPEID'] ;
		 	 	//check what type to Add 
		 	 	if($typeID == 2){
		 	 		$type = "Specific Survey" ;
		 	 	}
		 	 	else 
		 	 		$type = "Anonymous Survey"
		 	 	?>
		 	 	<br>
		 	 	<a href="#" id=<?=$surveyID?> class="big-link" data-reveal-id="modalEmails<?=$surveyID?> "></a>
		 	 	<div id="modalEmails<?=$surveyID?>" class="reveal-modal">
		 	 		<h1>Emails List</h1>
		 	 		<ul>
		 	 			<?php
						//get emails related to this survey.
		 	 			$arr_result = getSEmails($surveyID);
		 	 			for( $i =0  ; $i < sizeof($arr_result); $i++) {
                                                       if(!($arr_result[$i] == $user_email)){
		 	 				?>
		 	 				<li><?= $arr_result[$i]?></li>
		 	 				<?php 		
		 	 			}
                                       }
		 	 			?>
		 	 		</ul>
		 	 		<a class="close-reveal-modal">&#215;</a>
		 	 	</div>
		 	 	<div class = "surveys-details">
		 	 		<div class = "row"> 
		 	 			<div class = "col-md-10">
		 	 				<div class = "col-md-3">
		 	 					<div class = "row">
		 	 						<?=$survey_title ?>
		 	 					</div>
		 	 					<div class = "row">
		 	 						Date Created: <?=$survey_date?>
		 	 					</div>
		 	 					<div class = "row">
		 	 						Responses: <?=$responses_num?>
		 	 					</div>
		 	 					<div class = "row">
		 	 						Type: <?=$type?>
		 	 					</div>
		 	 					<div class = "row">
		 	 						<a target="_blank" href="<?=$survey_link?>"> Link </a>
		 	 					</div>
		 	 				</div>
		 	 				
		 	 				<div  class = "col-md-3">
		 	 					<button id="analysis-but" onclick="window.location.href='../analysis/analysis.php?survey=<?=$surveyID?>';" class ="btn-customize-profile analysis-bot" name=<?=$surveyID?> >Analysis</button>
		 	 					<?php 
		 	 					if($type == 'Specific Survey'){	
		 	 						?>
		 	 						<button id="view-emails" onclick=" document.getElementById(<?=$surveyID?>).click(); " class ="btn-customize-profile analysis-bot" 		name=<?=$surveyID?> >View Invited </button>
		 	 						<?php
		 	 					}
		 	 					?>
		 	 				</div>
		 	 			</div>
		 	 			<div class = "col-md-1">
		 	 				<div class = "button-icon">
		 	 					<a href='delete-survey.php?link=<?= $linknum ?>' onclick="return confirm('Are you sure you want to delete?');" name=<?=$surveyID?>><img src="../images/delete-button.png"></a>
		 	 				</div>
		 	 			</div>
		 	 		</div>
		 	 	</div>
		 	 	<?php
		 	 }
		 	}
		 	else {
		 		?>
		 		<div class = "surveys-details">
		 			<div class = "row-no-surveys"> 
		 				No Surveys Created yet
		 			</div>
		 		</div>
		 		<?php
		 	}
		 	?>
		 </div>
		 <form id="chps" action="change_psswd.php" method="post"></form>
 	<div class = "contact-us container-fluid">
 		<div class = "row">
 			<div class = "colm-md-12">
 				Copyright ÃÂÃÂÃÂÃÂ© 2017 SurveyBerry
 			</div>
 		</div>
 	</div>
		</body>
		
	</htmL>