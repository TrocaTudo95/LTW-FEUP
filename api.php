<?php
$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST'){
    response(200,'RECEIVED POST',$_SERVER['PATH_INFO']);
}


//header('HTTP/1.0 404 Nothing to see here');


function response($status,$status_message,$data)
{
	header("HTTP/1.1 ".$status);
	
	$response['status']=$status;
	$response['status_message']=$status_message;
	$response['data']=$data;
	
	$json_response = json_encode($response);
	echo $json_response;
}

?>