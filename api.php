<?php
/**
 * This is just a demo REST API that provides 4 methods. text in {} represent variables:
 * GET (Returns id and api-key of user) - api.php/{username}/{password} DONE
 * POST (Register user) - api.php/{username}/{password}?email={value} DONE
 * PUT (Reset an user's password) - api.php/{apikey}/{user}/{newPassword} //user is used to add more security
 * DELETE - (Delete project owned by an user) - api.php/project/{apiKey}/{user}/{projectId}
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
		}else{
			response(200,'Success',$data);
		}
	}else{
		response(501,'Path not recognized',$paths);
	}
}

//With post we want to create a new user
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

function handlePut($dbh,$paths,$arguments){
	if (count($paths) == 3){
		$apiKey = $paths[0];
		$user = $paths[1];
		$newPass = $paths[2];
		if (checkApiKey($dbh,$user,$apiKey) == 0){
			updatePassword($dbh,$arguments['user'],$arguments['apiKey']);
			response(200,'Success',NULL);
			return;
		}
		response(418,'Incorrect key for the given user id',NULL);
		return;
	}
	response(501,'Use /{apiKey}/{userid}/{newpass}',NULL);
}
function handleDelete($dbh,$paths,$arguments){
	if(count($paths) == 2){
		if ($paths[0] == 'delete'){
			if ($paths[1] == 'project'){
				if (isset($arguments['apiKey']) && isset($arguments['user']) && isset($arguments['projectId'])){
					if (checkApiKey($dbh,$arguments['user'],$arguments['apiKey']) == 0){ //success
						$deleteResult = deleteProject($dbh,$arguments['projectId'],$arguments['user']);
						if ($deleteResult == 0){
							response(200,'Success',NULL);
							return;
						}
						response(418,'User is not the owner or project does not exist',NULL);
						return;

					}
					response(418,'Incorrect key for the given user id',NULL);
					return;
				}
			}
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