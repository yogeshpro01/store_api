<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	include_once '../config/db.php';
	include_once '../items/product.php';

	$db = new db();
	$connect = $db->connect();
	$item = new item($connect);

	$input = json_decode(file_get_contents("php://input"));

	if(!empty($input->names) && !empty($input->amount)){
		$price = 0; 
		for($i=0; $i<count($input->names); $i++){
			$item->name = $input->names[$i];
			$amt = (int) $input->amount[$i];
			$req = $item->buy();
			$row = mysqli_fetch_assoc($req);
			$cur_price = (int) $row['price'];
			$price = $price + $amt*$cur_price;
			echo $amt;
		}
		http_response_code(200);
		echo json_encode(array("price" => $price));
	}else{
		http_response_code(400);
		echo json_encode(array("message" => "Invalid request."));
	}

?>