<?php
 
// Establishing Connection with Server by passing server_name, user_id and password as a parameter
$connection = new mysqli("localhost", "root", "password", "profile");
 echo "hello";
session_start();// Starting Session
 
// Storing Session
$user_check = $_SESSION['login_user'];
 
// SQL Query To Fetch Complete Information Of User
$result = $connection->query("select * from tbluser where email='$user_check'");
 
$row = $result->fetch_assoc();
 
//set the value of the email to the session
$login_session = $row['email'];
 
if(!isset($login_session))
{
    $connection->close(); // Closing Connection
    header('Location: index.php'); // Redirecting To Home Page
}
 
?>
