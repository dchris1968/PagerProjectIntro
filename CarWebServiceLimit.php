<?php 
	/*******************************
	 **    CarWebServicesLimit    **
	 **     December 10, 2014     **
	 **	  Douglass C. De Antonio  **
	 *******************************/

	$con = mysqli_connect("127.0.0.1","root","","cars"); 
	$result = mysqli_query($con,"SELECT * FROM car;"); 
	$total = mysqli_query($con,"SELECT COUNT(id) FROM car;");
	$count = mysqli_fetch_row($total); 
	$start = $_GET["start"]; 
	$return = $_GET["return"]; 


	if(isset($_GET['start']) && isset($_GET['return']))	
	{
		$startPos =  $_GET['start'];
		$total = $_GET['return'];
	}
	
	$limit = 'LIMIT '.$start .','.$return;
	$result = mysqli_query($con,"SELECT * FROM car $limit;");
	$data = array();
	
	while($row = mysqli_fetch_assoc($result))
	{
		//echo $row['id']." ".$row['year']." ".$row['make']." ".$row['model']." ".$row['color']." ";
		array_push($data, $row);
	}
	array_push($data, array("Count" => $count));

	mysqli_close($con); 
	echo json_encode($data); 
?>