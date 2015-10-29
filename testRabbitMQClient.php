
<?php

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function send($type){
	echo "<h1>$type</h1>";	
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
	echo"test 3<p>";
	$response = $client->send_request($request);
	if (!$response)
	{
		echo "no response!<p>";
	}
	else
	{
		echo "response reveived!<p>";
		var_dump($response);
		foreach($response as $item)
		{
			echo "item:<p>";
			print_r($item);
		}
	}
//	echo "<h1>$response</h1>";
	//$response = $client->publish($request);
	
	//echo "client received response: ".PHP_EOL;
	//echo $response;
	//echo "\n\n";

//	echo $argv[0]." END".PHP_EOL;
}

?>
