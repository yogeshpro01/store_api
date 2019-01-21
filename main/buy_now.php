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

	if(!empty($input->name)){
		$item->name = $input->name; 
		$req = $item->buy();
		$row = mysqli_fetch_assoc($req);
		if(!empty($row['name'])){
			if($row['inv_count'] > 0){
				if($item->execute()){

					$token = array(
						"iss" => $iss,
						"aud" => $aud, 
						"iat" => $iat,
						"nbf" => $nbf,
						"data" => array(
							"name" => $item->name
							// more important data
						)
					);

					http_response_code(201);
					$jwt = JWT::encode($token,$key);
					echo json_encode(
       					array("message" => "Product bought succesfully.",
       						"jwt" => $jwt
       					)
    				);
    			}else{
    				http_response_code(503);
    				echo json_encode(
       					array("message" => "Error purchasing the product.")
    				);
    			}
			}else{
				http_response_code(400);
				echo json_encode(
       				array("message" => "This product is out of stock.")
    			);
			}
		}else{
			http_response_code(400);
			echo json_encode(
       			array("message" => "No products found.")
    		);
		}
	}else{
		http_response_code(400);
		echo json_encode(
       			array("message" => "Invalid request.")
    		);
	}

?>