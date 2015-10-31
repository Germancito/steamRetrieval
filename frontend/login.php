<?php
 
session_start(); // Starting Session
$error=''; // Variable To Store Error Message
 
if (isset($_POST['submit'])) 
    {
        if (empty($_POST['pass']) || empty($_POST['email'])) 
        {
            $error = "Username(email) or Password is invalid";
        }
        else
        {
            // Define $email and $pass
            $email = $_POST['email'];
            $pass = $_POST['pass'];
             
            // Establishing Connection with Server by passing server_name, user_id and password as a parameter
            $connection = new mysqli("localhost", "root", "password", "profile");
             
            // Check connection
            if ($connection->connect_error) 
            {
                die("Connection failed: " . $connection->connect_error);
            } 
             
            $crypted = base64_encode($pass);
             
            // SQL query to fetch information of registerd users and finds user match.
            $result = $connection->query("select * from tbluser where   email='$email' and pass ='$crypted'");
             
            if ($result->num_rows > 0) 
            {
                $_SESSION['login_user']= $email; // Initializing Session
                header("location: profile.php"); // Redirecting To Other Page
            }
            else
            {
                $error = "Username or Password is invalid "  ;
            }
             
            $connection->close(); // Closing Connection
    }
}
?>
