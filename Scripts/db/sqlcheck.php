<?php
//local host database

 //000webhost local database 
  /* $servername = "localhost";
  $user_name = "id830744_sberry";
  $db_password = "master810";
  $database = "id830744_sberrt_db";*/
  
  // $servername = "localhost";
  // $user_name = "root";
  // $db_password = "";
  // $database = "sberry_db";

  $servername = "masterdb.calildp1rap7.us-west-2.rds.amazonaws.com";
  $user_name = "sberry";
  $db_password = "Master810";
  $database = "sberry_db";
  $port = '3306';


  try
  {
    $Database = new PDO("mysql:host=$servername;dbname=$database", $user_name, $db_password);
  }
  catch (PDOException $e)
  {
    echo "There was an unexpected error. Please try again, or contact us with concerns";
  }

  function  queryDB($queryString){
    global $Database ;
    $stmt = $Database->prepare($queryString);
    $stmt->execute();
    return $stmt;
  }

//PDO statement to execute and query the Database
  function getRowCount($stmt){
    return $stmt->rowCount(); 
  }

  function fetch($stmt){
    return $stmt->fetch(); 
  }

  function fetchAll($stmt){
    return $stmt->fetchAll(); 
  }

  function closeDB(){
    global $Database ;
    $Database->close();
  }


//User table information
  function getUserTable(){
   return "user";
 }

 function getUserIDColumn(){
   return "USERID" ;
 }
 function getEmailColumn(){
   return "EMAIL" ;
 }
 function getUsernameColumn(){
   return "USERNAME" ;
 }
 function getHashcodeColumn(){
   return "HASHCODE" ;
 }
//Response Table informatiojn
 function getResponseTable(){
   return "response" ;
 }

 function getSurveyTitle($surveyid){
  $query = "SELECT TITLE FROM survey WHERE SURVEYID = $surveyid " ;
  $stmt = queryDB($query);
  $result = fetch($stmt)[0];
  return $result ;
}
//return questions as a php associative array
function getSurveyQuestions($surveyid){
//Get QUESTIONID and TITLE from Database
  $query = "SELECT QUESTIONID,TITLE FROM question WHERE SURVEYID  = '$surveyid' ; " ;
  $stmt = queryDB($query) ;
  $data= array();
  while ($row = $stmt ->fetch(PDO::FETCH_ASSOC)) {
   $data["".$row['QUESTIONID']."" ] = "". $row['TITLE'] ."" ;
 }
 return $data ;
}
function getSurveyQuestionNum($surveyid){
  $query = "SELECT COUNT(QUESTIONID) as NUM  FROM question WHERE SURVEYID  = '$surveyid' ; " ;
  $stmt = queryDB($query);
  $result = fetch($stmt)[0];
  return $result ;
}
//Question table query Methods 
//--------------------------------------------------------------------------------
function getQuestionType($questionid){
  $query = " SELECT t.TITLE as Type FROM question as q INNER JOIN questiontype t ON q.QUESTIONTYPEID=t.QUESTIONTYPEID WHERE q.QUESTIONID = '$questionid' ;" ;
  $result = fetch(queryDB($query))[0];
  return $result ;
}

//return array of the responseID and Answer relating to a questionID
function getQuestionAnswers($questionid){
  $query = " SELECT r.RESPONSEID, r.ANSWER as answer FROM question as q INNER JOIN response r ON q.QUESTIONID= r.QUESTIONID WHERE q.QUESTIONID = '$questionid' ;" ;
  $stmt = queryDB($query);
  $result = $stmt -> fetchAll();
  $i = 0 ;
  $arr = array();
  foreach( $result as $row ) {
    $arr[$i] = $row ['answer'] ;
    $i++;
}
  return $arr;
}

//-----------------------------------------------------------------------
//return the number of responses to a specific answer and question ID and type
function getQuestionAnswerCount($questionid,$answer,$questiontype){
  if($questiontype == "MC" || $questiontype == "TF"  ||  $questiontype == "Likert"){
    $query = " SELECT r.ANSWER,COUNT(r.ANSWER) as NUM FROM question as q INNER JOIN response r ON q.QUESTIONID= r.QUESTIONID WHERE q.QUESTIONID = '$questionid' AND r.ANSWER = '$answer';" ;
    $result = fetch(queryDB($query))[1];
    return $result ;
  }

  else if($questiontype == "Text"){
    $query = " SELECT COUNT(r.ANSWER) as NUM FROM question as q INNER JOIN response r ON q.QUESTIONID= r.QUESTIONID WHERE q.QUESTIONID = '$questionid' ;" ;
     $result = fetch(queryDB($query))[0];
    return $result ;
  }
  else 
    return null ;
}

//get contents according to the questionid and question type
//if mc return an array , if text return a string , if TF return boolean
function getQuestionContents($questionid,$questionType){
  $query = " SELECT q.CONTENTS  FROM question as q WHERE q.QUESTIONID = '$questionid';" ;
  $result = fetch(queryDB($query))[0];

  if($questionType == 'MC'){
    $arr = explode(";",$result);
    return $arr ;
  }
  else if($questionType == 'TF'){
    $result = ['true','false'];
    return $result;

  }
  else if($questionType == 'Text'){
    return $result ;
  }
  else if ($questionType == 'Likert'){
    return $result ;
  }

  else {
    return  null;
  }
}
function getQuestionTotalResponses($questionid){
  $query = " SELECT COUNT(r.ANSWER) as answer FROM question as q INNER JOIN response r ON q.QUESTIONID= r.QUESTIONID WHERE q.QUESTIONID = $questionid ;";
  $result = fetch(queryDB($query))[0];
  return $result ;
}

//-----------------------------------------------------------------------------------------
function getRespondendID($questionid){
 $query = " " ; 
 $result = fetch(queryDB($query))[0];
 return $result ;
}


function getSEmails($surveyid){
$query = " SELECT EMAIL FROM survey_permissions WHERE SURVEYID = $surveyid ;";
$stmt = queryDB($query);
$result = $stmt -> fetchAll();
$i = 0 ;
  $arr = array();
  foreach( $result as $row ) {
    $arr[$i] = $row ['EMAIL'] ;
    $i++;
}
  return $arr;
}

?>


