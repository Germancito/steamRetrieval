
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function send($type,$steamid){
$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
if (isset($argv[1]))
{
  $msg = $argv[1];
}
else
{
  $msg = "test message";
}

$request = array();
$request['type'] = "$type";
$request['steamid'] = "$steamid";
//$request['password'] = "password";
//$request['message'] = $msg;
$response = $client->send_request($request);
//$response = $client->publish($request);

$i=0;
foreach($response as $em)
{

	if($i==0){
		echo "<img src=$em>";
		echo "\r\n";
		$i++;	
	}
	else
	{
		echo $em;
		echo "<br>";
		$i--;	
	}
}

//echo "client received response: ".PHP_EOL;
//print_r($response);
//echo "\n\n";

echo $argv[0]." END".PHP_EOL;
}
?>
