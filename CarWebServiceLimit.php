<?php $con = mysqli_connect("127.0.0.1","root","","cars"); ?>
<?php $result = mysqli_query($con,"SELECT * FROM car;"); ?>
<?php $total = mysqli_query($con,"SELECT COUNT(id) FROM car;"); ?>
<?php $count = mysqli_fetch_row($total); ?>
<?php $start = $_GET["start"]; ?>
<?php $return = $_GET["return"]; ?>

<?php
	if(isset($_GET['start'])) && ($_GET['return'])
	{
		$startPos = preg_replace('#[^0-'$count']#', '', $_GET['start']);
		$total = preg_replace('#[^0-'$count']#', '', $_GET['return']);
	}
	$limit = 'LIMIT '.$start .','.$return;
	$result = mysqli_query($con,"SELECT * FROM car $limit;");
?>


<?php 
	$data = array();
	while($row = mysqli_fetch_assoc($result))
	{
		//echo $row['id']." ".$row['year']." ".$row['make']." ".$row['model']." ".$row['color']." ";
		array_push($data, $row);
	}
	array_push($data, array("Count" => $count));
?>

<?php mysqli_close($con); ?>
<?php echo json_encode($data); ?>