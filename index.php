<?php
# Logging in with Steam accounts requires setting special identity, so this example shows how to do it.
# http://steamcommunity.com/dev/
require 'openid.php';
/*
#connects to my database and checks to make sure its connected.
*/
$apikey="238E8D6B70BF7499EE36312EF39F91AA";
try {
    # Change 'localhost' to your domain name.

    $openid = new LightOpenID('localhost');
    if(!$openid->mode) {
        if(isset($_GET['login'])) {
            $openid->identity = 'http://steamcommunity.com/openid';
            header('Location: ' . $openid->authUrl());
        }
?>
<form action="?login" method="post">
    <input type="image" src="http://cdn.steamcommunity.com/public/images/signinthroughsteam/sits_large_border.png">
</form>
<?php
    } elseif($openid->mode == 'cancel') {
        echo 'User has canceled authentication!';
    } else {
        if($openid->validate()) {
                $id = $openid->identity;
                // identity is something like: http://steamcommunity.com/openid/id/76561197994761333
                // we only care about the unique account ID at the end of the URL.
                $ptn = "/^http:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
                preg_match($ptn, $id, $matches);
                echo "User is logged in (steamID: $matches[1])\n";
		
		/*
		#playerInfo inserts our steam api key into the link, to gain access to steams data
		#it also uses a players steamid to search their particular infoin this case we use 
		#the matched result for the steam id, which was obtained by having the user log in.
		*/		
		$playerInfo="http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=$apikey&steamids=$matches[1]";
		$friendData="http://api.steampowered.com/ISteamUser/GetFriendList/v0001/?key=$apikey&steamid=$matches[1]&relationship=friend";
		$jsonObject=file_get_contents($playerInfo);
		//echo $jsonObject;
		$json_decoded=json_decode($jsonObject);
		//echo $json_decoded->response->players[0]->avatar;		
		$jsonFriendList=file_get_contents($friendData);
		echo $jsonFriendList;
		$json_decodeFriends=json_decode($jsonFriendList);
		
		/*
		#When not requesting for a different file format
		#steam will output its data in a JSON.here I am 
		#taking the decoded JSON file and reading through 
		#for particular information;		
		*/
		
		//echo $json_decoded->response->players[0]->avatar;
		echo $json_decodeFriends->friendslist->friends[0]->steamid;
		$db=mysqli_connect("localhost","root","password","profile");
		//var_dump($db);
		if (!mysqli_ping($db)) {
		    echo 'Lost connection, exiting after query #1';
		    exit;
		}

		foreach($json_decoded->response->players as $player)
		{
			$persona = $player->personaname;
			$sID = $player->steamid;
			$avatar = $player->avatar;
			
			$sql_fetch_id ="SELECT * FROM users WHERE steamid = $sID";
			//var_dump($db);
			$query_id= mysqli_query($db,$sql_fetch_id);
			
			
			if(mysqli_num_rows($query_id)==0)
			{
				//echo "nothing Found Inserting Data";
				$storeProfile = "INSERT INTO users(name,steamid,avatar) VALUES ('$persona','$sID','$avatar');";
				$q = mysqli_query($db,$storeProfile);
				var_dump($q);
			}
			else
			{
				//echo ("db not found");
			}
			
		}
        } 
	else 
	{
                echo "User is not logged in.\n";
        }

    }
} catch(ErrorException $e) {
    echo $e->getMessage();
}
?>
