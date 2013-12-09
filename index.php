<?php
$con = mysqli_connect("127.0.0.1", "root","","cars");
$sql = "SELECT count(id) FROM car";
$query = mysqli_query($con, $sql);
$row = mysqli_fetch_row($query);

//Here we have the total row count
$rows = $row[0];

//This is the number of results we want displayed per page
$page_rows = 5;

//This tells us the page number of our last page
$last = ceil($rows/$page_rows);

//This makes sure last cannot be less than 1
if($last < 1)
{
	$last = 1;
}
//Establish the $pagenum variable
$pagenum =1;

//Get pagenum from URL vars if it is present, else it is = 1
if(isset($_GET['pn']))
{
	$pagenum = preg_replace('#[^0-9]#','',$_GET(['pn']));
}
//This makes sure the page number isn't below 1, or more than our $last page
if($pagenum < 1) 
{
	$pagenum = 1;
}
else if ($pagenum > $last) 
{
	$pagenum = $last;
}
//This sets the range of rows to query for the chosen $pagenum
$limit = 'LIMIT'.($pagenum -1) * $page_rows.','.$page_rows;

//This is your query again, it is for grabbing just one page worth of rows by applying $limit
$sql = "SELECT * FROM car $limit";
$query = mysqli_query($con, $sql);

//This shows the user what page they are on, and the total number of pages
$textline1 = "Cars (<b>$rows</b>)";
$textline2 = "Page <b>$pagenum</b> of <b>$last</b>";

//Establish the $paginationCtrls variable
$paginationCtrls = '';

//If there is more than 1 page worth of results
if($last != 1)
{
	/* First we check if we are on page one.  If we are then we don't need a link to
	   the previous page or the first page so we do nothing.  If we aren't then we 
	   generate links to the first page, and to the previous page. */
	if ($pagenum > 1) {
		$previous = $pagenum - 1;
		$paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$previous.'">Previous</a> &nbsp; &nbsp;';
		
		//Render clickable number links that should appear on the left of the target page number
		for($i = $pagenum-4; $i < $pagenum; $i++){
			if($i > 0){
				$paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a> &nbsp;';
			}
		}
	}
	//Render the target page number, but without it being a link
	$paginationCtrls .= ''.$pagenum.' &nbsp; ';
	
	//Render clickable number links that should appear on the right of the target page number
	for($i = $pagenum+1; $i <= $last; $i++)
	{
		$paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a> &nbsp;';
		if($i >= $pagenum+4){
			break;
		}
	}
	
	//This does the same as above, only checking if we are on the last page, and then generating the "Next"
	if($pagenum != $last){
		$next = $pagenum + 1;
		$paginationCtrls .= ' &nbsp; &nbsp; <a href="'.$_SERVER['PHP_SELF'].'?pn='.$next.'">Next</a>';
	}
}
	$list = '';
	while($row = mysqli_fetch_array($query, MYSQLI_ASSOC))
	{
		$id = $row["id"];
		$make = $row["make"];
		$model = $row["model"];
		$year = $row["year"];
		$color = $row["color"];
		$list .= '<p>'.$id.' '.$make.' '.$model.' '.$year.' '.$color.' </p>';
	}
//Close your database connection
mysqli_close($con);

?>
<!DOCTYPE html>

<head>
	<title>Pager Project Intro</title>
	<meta charset="utf-8" />
</head>

<body>

	<div id="main-content">
		<?php echo $list; ?> 
	</div>

</body>
</html>