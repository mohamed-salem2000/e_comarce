<?php

//fetch_data.php

include('database_connection.php');

if(isset($_POST["action"]))
{
	$query = "
		SELECT * FROM videogame WHERE videogame_status = '1'
	";
	if(isset($_POST["minimum_price"], $_POST["maximum_price"]) && !empty($_POST["minimum_price"]) && !empty($_POST["maximum_price"]))
	{
		$query .= "
		 AND videogame_price BETWEEN '".$_POST["minimum_price"]."' AND '".$_POST["maximum_price"]."'
		";
	}
	if(isset($_POST["brand"]))
	{
		$brand_filter = implode("','", $_POST["brand"]);
		$query .= "
		 AND videogame_brand IN('".$brand_filter."')
		";
	}
	if(isset($_POST["ram"]))
	{
		$ram_filter = implode("','", $_POST["ram"]);
		$query .= "
		 AND videogame_color IN('".$ram_filter."')
		";
	}
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$total_row = $statement->rowCount();
	$output = '';
	if($total_row > 0)
	{
		foreach($result as $row)
		{
			$output .= '
			<div class="col-lg-4 col-sm-6">
			<div class="single_product_item">
			<img src="data:image/jpeg;base64,'.base64_encode($row['videogame_image']).'" alt="User Image" >
					<div class="single_product_text">
					<h4>' .$row["videogame_name"].'</h4>
					<h3>'.$row["videogame_price"].'</h3>
					<a href="videogame.php?value='.$row["videogame_id"].'" class="add_videogamet">+ add to videogamet<i class="ti-heart"></i></a>
				</div>
				</div>
			</div>
			';
		}
	}
	else
	{
		$output = '<h3>No Data Found</h3>';
	}
	echo $output;
}

?>