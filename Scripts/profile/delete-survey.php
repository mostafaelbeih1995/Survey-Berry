<?php
$delete_status = "";
if (isset($_GET["link"])) {
	$surveyLink = $_GET["link"] ;
} 
require('../db/sqlcheck.php');
echo $surveyLink ;
$stmt = queryDB("SELECT LINKSTRING FROM survey WHERE LINKSTRING= '$surveyLink' ") ;
$number_of_rows = getRowCount($stmt);
$result = fetch($stmt);
if($number_of_rows > 0){
//delete from survey table	
$query = "DELETE FROM survey WHERE LINKSTRING= '$surveyLink' ;" ;
$stmt = $Database->prepare($query);
$stmt->execute();
$delete_status = "success";
header("location:profile.php?deleteStatus=".$delete_status.""); 
}
else {
$delete_status = "fail ";
header("location:profile.php?deleteStatus=".$delete_status.""); 
}
?>