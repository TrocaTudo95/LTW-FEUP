<?php
/**
 * This is just a demo REST API that provides 4 methods. text in {} represent variables:
 * GET (Returns id and api-key of user) - api.php?username={value}password={value}
 * POST (Register user) - api.php/register?username={value}&password={value}&email={value}
 * PUT (Reset an user's password) - api.php/{api-key}/reset?user={value}&newPassword={value} //user is used to add more security
 * DELETE - (Delete project owned by an user) - api.php/{api-key}/delete/{project-title}?user={value}
 */


include_once('database/connection.php');
include_once('database/users.php');

$method = $_SERVER['REQUEST_METHOD'];
$paths = NULL;
if (isset($_SERVER['PATH_INFO'])){
	$paths= explode("/",$_SERVER['PATH_INFO']);
	array_shift($paths); // To remove 1st empty string
}

$parameters = explode("&",$_SERVER['QUERY_STRING']);
$parameters = mapParameters($parameters);

if ($method == 'POST'){
	handlePost($dbh,$paths,$parameters);
}else if ($method == 'GET'){
	handleGet($dbh,$paths,$parameters);	
}else if ($method == 'PUT'){
	handlePut($dbh,$paths,$parameters);
}else if ($method == 'DELETE'){
	handleDelete($dbh,$paths,$parameters);
}
else{
	response(501,'Method not implemented yet',NULL);
}

function handleGet($dbh,$paths,$parameters){
	if (count($paths) == 0){
		if (isset($parameters['username']) && isset($parameters['password'])){
			$apiKey = getApiKey($dbh,$parameters['username'],$parameters['password']);
			$userId = getUserId($dbh,$parameters['username']);
			$data['api-key'] = $apiKey;
			$data['user-id'] = $userId;
			if ($apiKey == -1 || $userId == -1){
				response(418,'Incorrect Credentials',$data);
			}else{
				response(200,'Success',$data);
			}
		}else{
			response(418,'Invalid Credentials',NULL);
		}
	}else{
		response(501,'Path not recognized',$paths);
	}
}

//With post we want to create a new user
function handlePost($dbh,$paths,$parameters){
	if (count($paths) == 1 && $paths[0]=='register'){
		if (isset($parameters['username']) && isset($parameters['password']) && isset($parameters['email'])){
			try{
				$result = register($dbh,$parameters['username'],$parameters['password'],$parameters['email']);
				if ($result == 0){
					response(201,"user registered with success",NULL);
				}else if ($result == -1){
					response(418,"username already exists in the database",NULL);
				}else if ($result == -2){
					response(418,"email already exists in the database",NULL);
				}
			}catch(PDOException $e){
				respose(500,$e->getMessage(),NULL);
			}
		}else{
			response(418,'Missing arguments',NULL);
		}
	}else{
		response(501,'Functionalitty Not Implement Yet',NULL);
	}
}

function handlePut($dbh,$arguments){

}
function handleDelete($dbh,$arguments){

}
function response($status,$status_message,$data)
{
	header("HTTP/1.1 ".$status);
	
	$response['status']=$status;
	$response['status_message']=$status_message;
	$response['data']=$data;
	
	$json_response = json_encode($response);
	echo $json_response;
}

function mapParameters($parameters){
	$map = [];
	foreach($parameters as $parameter){
		$keyValue = explode("=",$parameter);
		$map[$keyValue[0]] = $keyValue[1];
	}
	return $map;
}

?>