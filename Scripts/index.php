 <?php
 session_start();


   //Survey Does not exist
 if (isset($_GET["msg"]) && $_GET["msg"] == 'Survey not found') {
 	header("location:respondents/errors.php?found=false"); 
 } 
 	//If session Already Exist
 if (isset($_SESSION["name"]) && isset($_SESSION["email"]) ) {
 	header("location:profile/profile.php"); 
 } 
 else {
 	session_destroy();
 }

 ?>
 <html>

 <head>
 	<title>
 		SurveyBerry
 	</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" type="text/css" href="slick/slick.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Merriweather" rel="stylesheet">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <script type="text/javascript" src="slick/slick.min.js"></script>
        <script src="script.js" type="text/javascript"></script>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link rel = "icon" href = "images/raspberry.png">
        <link rel="stylesheet" type="text/css" href="css/mystyle.css">

    </head>
 <body>
 	<div class = "logo-title links">
 		<h1><a href = "index.php">SurveyBerry <img src = "images/raspberry.png"> </a></h1>
 	</div>
 	<div class = "container">
 		<div class = "main">
 			<div class = "row">

 				<div class= "col-md-6">
 					<h3 style = "text-align: left;">How to use the software: </h3>
 					<div class = "row">
 						<div class = "col-md-12" style = "margin-left: 20px;">
 							<div class = "row">
		 						<div class = "left-arrows">
		                                <i class="fa fa-arrow-left fa-2x" aria-hidden="true"></i>
		                        </div>
		                        <div class = "right-arrows">
		                                <i class="fa fa-arrow-right fa-2x" aria-hidden="true"></i>
	                            </div>
	 							<div class = "slider">
	 								<div class = "slide-1">
	 								<img src="images/download-button.png">
	 									<div class = "content">
	 										
	 										<h3>Sign up and Download the SDK</h3>
	 									</div>
	 									
	 								</div>
	 								<div class = "slide-1">
	 								<img src="images/sdk.jpg">
	 									<div class = "content">
	 										
	 										<h3>Extract the file and open it</h3>
	 										<p>
	 											You can run the batch file to see what 
	 											it do you expect the SDK does

	 										</p>
	 									</div>
	 									
	 								</div>
	 								<div class = "slide-1">
	 								<img src="images/sample.png">
	 									<div class = "content">
	 									<h3>survey1.bry </h3>
	 										<p>This file is a sample of the structure of
	 											how .bry files are formatted to generate a survey
	 											
	 										</p>
	 										<p>
	 											You can also write the email addresses to whome you 
	 											want to send links for the survey

	 										</p>	
	 										
	 									</div>
	 									
	 								</div>
	 								<div class = "slide-1">
	 								<img src="images/cmd.png">
	 									<div class = "content">
	 										
	 									<h3>Using the cmd </h3>
	 										<p>
	 											Open the cmd with the right location and then
	 											type what is in the screen shot
	 										</p>

	 									</div>
	 									
	 								</div>
	 								<div class = "slide-1">
	 									<div class = "content">
	 										<h3>What to do next ? </h3>
	 										<p>
	 											You can now sign in to the website and
	 											see what surveys you created and see the analysis 
	 											of the answers of each survey
	 										</p>
	 									</div>
	 								</div>
	 							</div>
	 						</div>
	 					</div>
 					</div>
 				</div>

 				<div class = "col-md-3 col-md-offset-3">
 					<h3>Sign in to SurveyBerry</h3>
 						<div class = "row">
 							<div class = "col-md-12">
 								<div class = "login">
			 						<form  method="post" action="login.php">
			 					<?php
			 						if (!empty($_SESSION['valid'])){
			 					?>
			 						<div class="error-login"> Invalid email or password </div>
			 						<?php } ?>
			 							<div class="form-group">
			 								<input type="email" class="form-control" id="email" name ="user_email" placeholder="Email">
			 							</div>
			 							<div class="form-group">
			 								<input type="password" class="form-control" id="pwd" name = "user_password" placeholder="Password">
			 							</div>
			 							<div class = "col-md-8 col-md-offset-4">
			 								<button type = "submit" class = btn-customize-index>login</button>
			 							</div>
			 						</form>	
			 						<form id="signup" method="post" action="signup.php">
			 						</form> 
	 							</div>
	 						</div>
	 					</div>
	 					<div class = "row">
	 						<div class ="col-md-12">
	 							<div class = "index-links">
		 							<form id="reset" action="reset.php" method="post" class = "links">
				 						<a href="javascript:{}" onclick="document.getElementById('reset').submit(); return false;" id ="forget">Forgot Password ? </a>
				 						<br>
				 						<a href="javascript:{}" onclick="document.getElementById('signup').submit(); return false;" id ="signup">Don't have an account ? Sign up </a>
	 								</form>
	 							</div>
	 					<form id="signup" method="post" action="signup.php">
	 					</form>
	 						</div>
 						</div>	
 				</div>
 			</div>
 		</div>
 	</div>
 	<div class = "berry_footer container-fluid">
 		<div class = "row">
 			<div class = "col-md-12">
 				<h2>How SurveyBerry can help you</h2>		
 			</div>
 		</div>
 		
 		<div class = "row">
 			<div class = "col-md-2">
	 			<img src="images/like.png">
	 			<p>Customer Satisfaction</p>
 			</div>

 			<div class = "col-md-2 col-md-offset-1">
	 			<img src="images/shopping-cart.png">
	 			<p>Market Research</p>
 			</div>

 			<div class = "col-md-2 col-md-offset-1">
	 			<img src="images/calendar.png">
	 			<p>Event Planning</p>
 			</div>

 			<div class = "col-md-2 col-md-offset-1">
	 			<img src="images/mortarboard.png">
	 			<p>Education & Schools</p>
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
