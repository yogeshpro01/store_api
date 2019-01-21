<?php
	header("Access-Control-Allow-Origin *");
	header("Content-Type: application/json; charset=UTF-8");
	include_once '../config/db.php';
	include_once '../items/product.php';
	$db = new db();
	$connect = $db->connect();
	$item = new item($connect);
	$pro = $item->get_all();

	$out = array();
	$out["info"] = array();
	$f = 0; 
	while($row = mysqli_fetch_assoc($pro)){
		if($row['inv_count']){
			$cur = array(
					"id" => $row['id'],
					"name" => $row['name'],
					"price" => $row['price'],
					"inventory_count" => $row['inv_count']
				);
			array_push($out["info"],$cur);
			$f = 1;
		}
	}
	if($f){
		http_response_code(200);
		echo json_encode($out);
	}else{
		http_response_code(404);
		echo json_encode(array("message" => "No products found."));
	}

?>