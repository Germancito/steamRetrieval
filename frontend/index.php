<!DOCTYPE html>
<?php
require 'openid.php';
require 'functions.php';
require 'testRabbitMQClient.php';
include 'login.php'; // Includes Login Script
try{ 


if(isset($_SESSION['login_user']))
{ 
    // here the session is checked. If session is filled, the user is logged-on
    //so, we redirect the user to the profile page
    header("location: profile.php");
}

$openid = new LightOpenID('localhost/loginPage/490project/index.php');
    if(!$openid->mode) {
        if(isset($_GET['login1'])) {
            $openid->identity = 'http://steamcommunity.com/openid';
            header('Location: ' . $openid->authUrl());
        }
?>
<html>
<head>
<title>Login</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
    <body>
        <div id="main">
            <div id="login">
            <h2>User Login</h2>
                <form action="" method="post">
                    <label>UserName :</label>
                    <input id="email" name="email" placeholder="email" type="text">
                    <label>Password :</label>
                    <input id="pass" name="pass" placeholder="**********" type="password">
                    <input name="submit" type="submit" value=" Login ">
                    <span><?php echo $error; ?></span>
                    <br />
                    <p> 
                        Use the steam button below to register if you do not have a login
			</p>
			<p>			
			NOTE: Before registration you will be asked to login into steam
			this is needed to ensure that people who register with our sevices
			do not use any other Steam Id but their own.
                        </p>
                        <br />
                      </form>
		  <form action="?login1" method="post">
    			<input type="image" src="http://cdn.steamcommunity.com/public/images/signinthroughsteam/sits_large_border.png">
			</form>            
		</div>
        </div>
    </body>
</html>
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
		session_start();
		$_SESSION['sid']=$matches[1];
		//echo $_SESSION['sid'];
		header('location: registerInput.php');                
		
		//echo "User is logged in (steamID: $matches[1])\n";
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
