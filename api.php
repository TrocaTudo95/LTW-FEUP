<?php
/**
 * This is just a demo REST API that provides 4 methods. text in {} represent variables:
 * 
 */

include_once('database/connection.php');
include_once('database/users.php');
include_once('database/projects.php');

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
/**
 * Returns id and api-key of user - api.php/{username}/{password} DONE
 * Returns list of all users -api.php/users DONE
 * Return projects owned by user - api.php/projects/{username}
 */
function handleGet($dbh,$paths,$parameters){
	if (count($paths) == 2){
		$username = $paths[0];
		$password = $paths[1];
		$apiKey = getApiKey($dbh,$username,$password);
		$userId = getUserId($dbh,$username);
		$data['api-key'] = $apiKey;
		$data['user-id'] = $userId;
		if ($apiKey == -1 || $userId == -1){
			response(418,'Incorrect Credentials',$data);
			return;
		}
		response(200,'Success',$data);
		return;
	}
	if (count($paths) == 1){
		if ($paths[0] == 'users'){
			$users = getAllUsers($dbh);
			response(200,'Success',$users);
			return;
		}
	}
	response(501,'Path not recognized',$paths);
	return;
}

/**
 * POST (Register user) - api.php/{username}/{password}?email={value} DONE
 */
function handlePost($dbh,$paths,$parameters){
	if (count($paths) == 2){
		$username = $paths[0];
		$password = $paths[1];
		$email = NULL;
		if (isset($parameters['email'])){
			$email = $parameters['email'];
		}
		try{
			$result = register($dbh,$username,$password,$email);
			if ($result == 0){
				$data = getUserByUsername($dbh,$username);
				response(201,"user registered with success",$data);
			}else if ($result == -1){
				response(418,"username already exists in the database",NULL);
			}else if ($result == -2){
				response(418,"email already exists in the database",NULL);
			}
		}catch(PDOException $e){
			respose(500,$e->getMessage(),NULL);
		}
	}else{
		response(501,'Use /{username}/{password}',NULL);
	}
}
/**
 * PUT (Reset an user's password) - api.php/{apikey}/{user}/{newPassword}
 */
function handlePut($dbh,$paths,$arguments){
	if (count($paths) == 3){
		$apiKey = $paths[0];
		$user = $paths[1];
		$newPass = $paths[2];
		if (checkApiKey($dbh,$user,$apiKey) == 0){
			updatePassword($dbh,$user,$newPass);
			response(200,'Success',NULL);
			return;
		}
		response(418,'Incorrect key for the given user id',NULL);
		return;
	}
	response(501,'Use /{apiKey}/{userid}/{newpass}',NULL);
}

// DELETE - (Delete project owned by an user) - api.php/project/{apiKey}/{user}/{projectId}
function handleDelete($dbh,$paths,$arguments){
	if(count($paths) == 2){
		if ($paths[0] == 'project'){
			$apiKey = $paths[1]
			$userId = $paths[2];
			$projectId = $paths[3];
			if (checkApiKey($dbh,$userId,$apiKey) == 0){ //success
				$deleteResult = deleteProject($dbh,$projectId,$userId);
				if ($deleteResult == 0){
					response(200,'Success',NULL);
					return;
				}
				response(418,'User is not the owner or the project does not exist',NULL);
				return;
			}
			response(418,'Incorrect key for the given user id',NULL);
			return;
		}
	}
	response(501,'Path not recognized',NULL);
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
	if (count($parameters) > 0){
		foreach($parameters as $parameter){
			$keyValue = explode("=",$parameter);
			if (isset($keyValue[0]) && isset($keyValue[1])){
				$map[$keyValue[0]] = $keyValue[1];
			}
		}
	}
	return $map;
}

?>