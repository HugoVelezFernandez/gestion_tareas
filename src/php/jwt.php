<?php

$secret_key = 'DAMANDDAW@2022';

function base64url_encode($data) {
 return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function jwt_encode ($payload) {
	global $secret_key;

	// base64 encodes the header json
	$arr = array('alg' => 'HS256', 'typ' => 'JWT');
	$arr2 = json_encode($arr);
	$encoded_header = base64url_encode($arr2);


	// base64 encodes the payload json
	$arr3 = $payload;
	$arr33 = json_encode($arr3);
	$encoded_payload = base64url_encode($arr33);

	// base64 strings are concatenated to one that looks like this
	$header_payload = $encoded_header .'.'. $encoded_payload;

	// Creating the signature, a hash with the s256 algorithm and the secret key. The signature is also base64 encoded.
	$signature = base64url_encode(hash_hmac('sha256', $header_payload, $secret_key, true));

	// Creating the JWT token by concatenating the signature with the header and payload, that looks like this:
	$jwt_token = $header_payload . '.' . $signature;

	//listing the resulted JWT
	return $jwt_token;
}

function jwt_decode ($recievedJwt) {
	global $secret_key;

	//if(!empty($recievedJwt)){$recievedJwt = "a";}

	// Split a string by '.' 
	$jwt_values = explode('.', $recievedJwt);

	// extracting the signature from the original JWT 
	$recieved_signature = $jwt_values[2];

	// concatenating the first two arguments of the $jwt_values array, representing the header and the payload
	$recievedHeaderAndPayload = $jwt_values[0] . '.' . $jwt_values[1];

	// creating the Base 64 encoded new signature generated by applying the HMAC method to the concatenated header and payload values
	$resultedsignature = base64url_encode(hash_hmac('sha256', $recievedHeaderAndPayload, $secret_key, true));


	// checking if the created signature is equal to the received signature
	if($resultedsignature == $recieved_signature) {
 // If everything worked fine, if the signature is ok and the payload was not modified you should get a success message
 return jwt_decode_payload($jwt_values[1]);
	}
	else {
 return false;
	}
}

function jwt_decode_payload ($payload) {
	$payload = preg_replace('/-/', '+', $payload);
	$payload = preg_replace('/_/', '/', $payload);

	$base64_decode = base64_decode($payload);

	$urldecode = urldecode($base64_decode);
	$urldecode = str_split($urldecode);

	$jsonPayload = '';

	foreach($urldecode as $value) {
 $c = JS_charCodeAt($value, 0);
 $c = '00'. base_convert($c, 10, 16);

 $jsonPayload .= '%'. substr($c, -2);
	}

	$jsonPayload = urldecode($jsonPayload);

	//

	return json_decode($jsonPayload);
}


function JS_charCodeAt ($str, $index) {
 $char = mb_substr($str, $index, 1, 'UTF-8');

 if (mb_check_encoding($char, 'UTF-8')) {
 $ret = mb_convert_encoding($char, 'UTF-32BE', 'UTF-8');

 return hexdec(bin2hex($ret));
 }
 else {
 return null;
 }
}

?>