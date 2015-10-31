#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
include 'functions.php';
//

function doLogin($username,$password)
{
    // lookup username in databas
    // check password
    return true;
    //return false if not valid
}

function requestProcessor($request)
{
  echo "received request".PHP_EOL;
  var_dump($request);
  if(!isset($request['type']))
  {
    return "ERROR: unsupported message type";
  }
  switch ($request['type'])
  {

    case "login":
      //return doLogin($request['username'],$request['password']);
      $auth=doLogin($request['username'],$request['password']);
	if($auth==true){
		return array('hello'=>'world');	
	}


    case "validate_session":
      return doValidate($request['sessionId']);

	//in case friends this will return a list of friends from
	//the the steam user, and send it in an array to the client.
   case "showFriends":
	return showFriends($request['steamid']);

   case "popFri":
	addFriendsToUsers($request['steamid']);

  case "add":
	retrieveUserInfo($request['steamid']);

	//return array("returnCode" => '0', 'message'=>"Server received request and processed");
  }
  //return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");

$server->process_requests('requestProcessor');
exit();
?>

