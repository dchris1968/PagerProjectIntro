<?php $make = $_GET['make']; ?>

<?php $con = mysqli_connect("127.0.0.1","root","","cars"); ?>
<?php $result = mysqli_query($con,"SELECT * FROM car;"); ?>

<?php 
	$data = array();
	while($row = mysqli_fetch_assoc($result))
	{
		//echo $row['id']." ".$row['year']." ".$row['make']." ".$row['model']." ".$row['color']." ";
		if (strtoupper($row['make']) == strtoupper($make))
		{
			array_push($data, $row);
		}
	}
	
?>

<?php mysqli_close($con); ?>
<?php echo json_encode($data); ?>