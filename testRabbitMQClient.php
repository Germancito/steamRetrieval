#!/usr/bin/php
<?php

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function send($type){
	$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
	if (isset($argv[1]))
	{
	  	$msg = $argv[1];
	}
	else
	{
	  	$msg = "test message";
	}
	
	//This will send an array to the server with ryp friends
	//when it does this the client will recieve friend information from the server
	$request = array();
	$request['type'] = "friends";
	$request['username'] = "steve";
	$request['password'] = "password";
	$request['message'] = $msg;
	$response = $client->send_request($request);
	//$response = $client->publish($request);

	echo "client received response: ".PHP_EOL;
	echo $response;
	echo "\n\n";

	echo $argv[0]." END".PHP_EOL;
}

?>