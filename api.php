<?php
/**
 * This is just a demo REST API that provides 4 methods. text in {} represent variables:
 * GET (Returns api-key of user) - api.php?user={value}password={value}
 * POST (Register user) - api.php/register?user={value}&password={value}
 * PUT (Reset an user's password) - api.php/{api-key}/reset?newPassword={value}
 * DELETE - (Delete project owned by an user) - api.php/{api-key}/delete/{project-title}
 */


include_once('database/connection.php');
include_once('database/users.php');

$method = $_SERVER['REQUEST_METHOD'];
$path = explode("/",$_SERVER['PATH_INFO']);
array_shift($path); // To remove 1st empty string
$parameters = explode("&",$_SERVER['QUERY_STRING']);
$parameters = mapParameters($parameters);

if ($method == 'POST'){
	handlePost($dbh,$path,$parameters);
}else if ($method == 'GET'){
	handleGet($dbh,$path);	
}else if ($method == 'PUT'){
	handlePut($dbh,$path);
}else if ($method == 'DELETE'){
	handleDelete($dbh,$path);
}
else{
	response(501,'Method not implemented yet',NULL);
}

//With post we want to login a user. Url example: api.php
function handlePost($dbh,$paths,$parameters){
	if (count($paths) == 1 && $paths[0]=='login'){
		if (userExists($dbh, $parameters['user'])){
			if (checkPassword($dbh, $parameters['user'],$parameters['password'])){
				$responseData['api-key'] = hash('sha256',$parameters['user']);
				response(200,'Login Successful',$responseData);
			}else{
				response(418,'Incorrect Password',NULL);
			}
		}else{
			response(418,'User does not exist',NULL);
		}
	}else{
		response(501,'Path not recognized',$paths);
	}
	
}
function handleGet($dbh,$arguments){
	response(200,'RECEIVED GET',$arguments);
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