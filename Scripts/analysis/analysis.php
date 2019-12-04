<?php
	session_start();
	if (!isset($_SESSION["name"]) && !isset($_SESSION["email"]) ) {
		header("location:../index.php"); 
		session_destroy();
	} 
	require("../db/sqlcheck.php");
	//Get information about the survey from the database
	//Get Responses in the form of data
	//Check permissions on anaylsis
	if (isset($_GET["survey"])) { //get survey ID
		$surveyid = $_GET["survey"] ; 
	}
	else {
 		echo "ERROR" ; // change for later
 	}

 	$title = getSurveyTitle($surveyid);
 	$numofQuestions = getSurveyQuestionNum($surveyid); //used to create number of canvas
 	$data = getSurveyQuestions($surveyid);
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
 		<link rel="stylesheet" type="text/css" href="analysis.css">
 		<link rel = "icon" href = "../images/raspberry.png">
 		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
 		<script src="../jquery-3.1.1.js"></script>
 		<script src="Chart.js"></script>

 	</head>
 	<body>
 		<div class = "logo-title links">
 			<h1><a href = "../index.php">SurveyBerry <img src = "../images/raspberry.png"></a></h1>
 		</div>
 		

 		<div class = "container">
 			<div class = "analysis-title">
 				<div class = "row">
 					<div class = "col-md-12">
 						<h1 id="analysis-survey-title"> <?= $title ?> </h1>
 					</div>
 				</div>
 				<div class = "row">
 					<div class = "col-md-10 col-md-offset-2">
 						<div id="questions-container">
 							<?php foreach( $data as $id => $qtitle){
 								$questionreposesCount = getQuestionTotalResponses($id) ;
 								$questionType = getQuestionType($id);
 								?>
 								<div id="question-div" >
 									<h2 id="question-title"> <?=$qtitle?></h2>
 									<div id=num-responses>  Responses :  <?= $questionreposesCount ?></div>
 									
 									<?php if($questionType == "Text"){?>
 									<div class = "row">
 										<div class = "col-md-11 col-md-offset-1">
 											<div id="<?=$id?>" class="Answer-text"></div>
 										</div>
 									</div>
 									<?php } 
 									else {
 										?>
 										<canvas class="canvasCharts" id=<?= $id ?>  ></canvas>  
 										<?php }  ?>

 									</div>	
 									<?php }?>
 									
 								</div>
 							</div>
 						</div>
 					</div>

 				</div>
 			</body>
 		<script type="text/javascript">
 			var labels = [];
 			var data = [];
 			var ar = []; 
 			var likertLabels = [] ;
 			var likertData = [];// array of answers for the text questions
 			//type variable if certain type wants to be chosen
 			function getArrayofColors(size){
 				var array = [] ;
 				for (i = 0; i < size; i++) {
 					array.push(getRandomColor());

 				}
 				return array ;
 			}
 			function getRandomColor() {
 				var letters = '0123456789ABCDEF'.split('');
 				var color = '#';
 				for (var i = 0; i < 6; i++ ) {
 					color += letters[Math.floor(Math.random() * 16)];
 				}
 				return color;
 			}
 			function drawChart(type,lables,data,canvasName,size){
 				var ctx = document.getElementById(canvasName).getContext('2d');
 				ctx.canvas.width = 500;
 				ctx.canvas.height = 450;
 				if(type == "bar"){
 					var myChart = new Chart(ctx, {
 						type: type,
 						data: {
 							labels: lables,
 							datasets: [
 							{
 								type: type,
 								label: 'Responses',
 								backgroundColor: getArrayofColors(size),
 								data: data
 							}
 							]
 						},
 						options: {
 							legend: {labels:{fontColor:"white", fontSize: 24}},
 							responsive: false,

 							scales: {
 								yAxes: [{
 									ticks: {
 										fontColor: "white",
 										fontSize: 24,
 										stepSize: 1,
 										beginAtZero:true
 									}
 								}],
 								xAxes: [{
 									ticks: {
 										fontColor: "white",
 										fontSize: 24,
 										stepSize: 1,
 										beginAtZero:true
 									}
 								}]
 							}

 						}
 					});}
 					if(type == "pie"){
 						var myChart = new Chart(ctx, {
 							type: 'pie',
 							data: {
 								labels: labels, 
 								datasets: [{
 									backgroundColor: getArrayofColors(size),
 									data: data
 								}]
 							},
 							options: {
 								legend: {labels:{fontColor:"white", fontSize: 24}},
 								responsive: false
 							}
 						});

 					}

 				}
 				<?php
 				$TextAnswers = array();
 				$LikertAnswers = array();
 	//Getting Surrvey Information  and Data into arrays to display on chart
 	//-------------------------------------------------------------------------------------------
 				foreach( $data as $id => $qtitle) {
 					$questionType = getQuestionType($id);
 					$questionContents =  getQuestionContents($id,$questionType);
 				//loop through the questions contents and get the responses for each answer
 					if($questionType == 'MC' || $questionType == "TF") {
 						for($i= 0 ; $i < sizeof($questionContents); $i++){
 							$count = getQuestionAnswerCount($id,$questionContents[$i],$questionType);
 							?>
 							labels.push("<?= $questionContents[$i]?>") ;
 							data.push ("<?= $count ?>");
 							<?php }
 							if ($questionType == 'MC') {?>
 								drawChart("bar",labels,data,"<?=$id?>","<?=sizeof($questionContents)?>");
 								data = [] ;
 								labels = [] ;
 								<?php
 							}
 							if($questionType == "TF"){
 								?>
 								drawChart("pie",labels,data,"<?=$id?>","<?=sizeof($questionContents)?>");
 								data = [] ;
 								labels = [] ;
 								<?php
 							}
 						}
 						if($questionType == 'Text') { //  should create a select element
 							$TextAnswers  = getQuestionAnswers($id) ;
 							$num = getQuestionAnswerCount($id,'',$questionType);
 							for($i = 0 ; $i < intval($num) ; $i++){ // adding text values to arrays
 								?>
 									var node = document.createElement("div");                 // Create a <li> node									
 									node.setAttribute('class','<?=$id?>'); 
 									node.style.marginTop = "10px";
 									document.getElementById("<?=$id?>").appendChild(node);									
 									var textA = document.getElementsByClassName("<?=$id?>");
 									var counter = parseInt('<?=$i?>') + 1 ;
 									textA[<?=$i?>].innerHTML = "Answer " + counter + " : "  + '<?= $TextAnswers[$i]?>' ;
 									<?php
 								}
 							}
 							if($questionType == 'Likert'){
 								$LikertContents = array("Strongly Agree","Agree","Neutral","Disagree","Strongly Disagree");
 								for($i= 0 ; $i < sizeof($LikertContents); $i++){
 									$countL = getQuestionAnswerCount($id,$LikertContents[$i],$questionType);
 									?>
 									
 										likertLabels.push("<?= $LikertContents[$i]?>");
 										likertData.push ("<?= $countL ?>");
 									<?php
 								}
 								?>
 								drawChart("bar",likertLabels,likertData,"<?=$id?>","<?=sizeof($LikertContents)?>");
 										likertData = [] ;
 										likertLabels = [];

 										<?php
 							}
 						}

 						?>
 	//-----------------------------------------------------------
 	
 	
 	
 </script>

 </html>