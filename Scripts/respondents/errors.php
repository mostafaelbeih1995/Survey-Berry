<?php

$locked = "";
$notPermission = "" ;
$notFound = "";
 
  if (isset($_GET["locked"]) && $_GET["locked"] == 'forusersonly') { 
  	$locked = "Survey locked for users Only, Please Sign in and try again" ;
 }  

if (isset($_GET["locked"]) && $_GET["locked"] == 'restricted') { 
 	$notPermission = "You do not have Permission to answer this Survey" ;
 }

 if (isset($_GET["found"]) && $_GET["found"] == 'false') { 
 	$notFound = "Survey not found" ;
 }
?>
<html>
	<head>
	<title>
		SurveyBerry
	</title>
		<div class = "logo-title links">
		<h1><a href = "../index.php">SurveyBerry <img src = "../images/raspberry.png"> </a></h1>
		</div>
		<meta charset="UTF-8">
		<meta name="viewport"
		content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
		<link rel = "icon" href = "../images/raspberry.png">
		<link rel="stylesheet" type="text/css" href="../css/mystyle.css">
		<link rel="stylesheet" href="../css/reveal.css">
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
		<script src="../jquery-3.1.1.js"></script>
	</head>
	<body>
		<div class="result-submit">
			<?php
				if($locked != ""){
					?>
					<h1><?=$locked?></h1>
					<?php
				}
				if($notPermission != ""){
					?>
					<h1><?=$notPermission?></h1>
					<?php
				}
				if($notFound != ""){
					?>
					<h1><?=$notFound?></h1>
					<?php
				}
			?>
			you will be redirected shortly , if you are not please <a href="../index.php">click this link</a>
			<script type="text/javascript">
			setTimeout("window.close();", 5000);</script>
		</div>

	</body>

	</html>