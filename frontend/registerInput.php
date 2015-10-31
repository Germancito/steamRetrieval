<!DOCTYPE html>
<html>
<head>
<title>Register</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
	session_start();	
	$var_value=$_SESSION['sid'];
	$var ="hello";
	//echo $var_value;
?>	
	<div id="main">
		<div id="login">
			<h2>New User</h2>
			<form action="register.php" method="post">
				<label>First Name :</label>
				<input id="firstname" name="firstname" placeholder="first name" type="text">
				<label>Last Name :</label>
				<input id="lastname" name="lastname" placeholder="last name" type="text">
				<label>Email :</label>
				<input id="email" name="email" placeholder="email" type="text">
				<label>Steam ID:</label>
				<input id="steamid" name="steamid" placeholder="<?php echo $var_value; ?>" type="text" value="<?php echo $var_value; ?>" readonly>
				<label>Password :</label>
				<input id="pass" name="pass" placeholder="**********" type="password">
				<br />
				<input name="submit" type="submit" value=" Register ">
				<span><?php echo $error; ?></span>
				<br />
			</form>
		</div>
	</div>
</body>
</html>
