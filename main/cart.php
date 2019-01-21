<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	include_once '../config/token.php';
	include_once '../libs/php-jwt-master/src/BeforeValidException.php';
	include_once '../libs/php-jwt-master/src/ExpiredException.php';
	include_once '../libs/php-jwt-master/src/SignatureInvalidException.php';
	include_once '../libs/php-jwt-master/src/JWT.php';
	include_once '../config/db.php';
	include_once '../items/product.php';
	use \Firebase\JWT\JWT;

	$db = new db();
	$connect = $db->connect();
	$item = new item($connect);

	$input = json_decode(file_get_contents("php://input"));

	if(!empty($input->names) && !empty($input->amount)){
		$f = 1; 
		for($i=0; $i<count($input->names); $i++){
			$item->name = $input->names[$i];
			$amt = $input->amount[$i];
			$req = $item->buy();
			$row = mysqli_fetch_assoc($req);
			if(empty($row['name']) || $row['inv_count']-$amt<0){
				$f = 0;
			}
 		}
		if($f){
			$f2 = 1; 
			for($i=0; $i<count($input->names); $i++){
				$item->name = $input->names[$i];
				$amt = $input->amount[$i];
				if(!$item->execute_more($amt)){
					$f2 = 1;
				}
			}
			if($f2){
				$token = array(
						"iss" => $iss,
						"aud" => $aud, 
						"iat" => $iat,
						"nbf" => $nbf,
						"data" => array(
							"names" => $input->names
							// more important data
						)
					);

					http_response_code(201);
					$jwt = JWT::encode($token,$key);
					echo json_encode(
       					array("message" => "Products bought succesfully.",
       						"jwt" => $jwt
       					)
    				);
			}else{
				http_response_code(503);
				echo json_encode(array("message" => "Error processing the request."));
			}
		}else{
			http_response_code(400);
			echo json_encode(array("message" => "Some of the products request do not exist or aren't currently available."));
		}
	}else{
		http_response_code(400);
		echo json_encode(array("message" => "Invalid request."));
	}

?>