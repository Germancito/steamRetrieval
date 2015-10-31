<?php
    include('session.php');
?>
<!DOCTYPE html>
<html>
<head>
<title>Edit</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
    <body>
        <?php
            // Create connection
                //database information 
                $conn = new mysqli("localhost", "root", "root", "test");
                 
                // Check connection
                if ($conn->connect_error)
                {
                    die("Connection failed: " . $conn->connect_error);
                } 
     
                // Storing Session
                $user_check = $_SESSION['login_user'];
                 
                $id = $_GET["id"];
                 
                if($id != "")
                {
                    $user_check = $id;
                }
                 
                // SQL Query To Fetch Complete Information Of User
                 
                $sql = "SELECT * FROM tbluser where idUser='$user_check'" ;
                $result = $conn->query($sql);
 
                    if ($result->num_rows > 0) 
                    {
                        // output data
                         $row = $result->fetch_assoc(); 
                ?>
        <div id="main">
            <div id="login">
            <h2>Update User</h2>
                <form action="update.php" method="post">
                    <label>First Name :</label>
                    <?php echo '<input id="firstname" name="firstname"   value="'.$row['firstName'].'" type="text">'; ?>
                    <label>Last Name :</label>
                    <?php echo '<input id="lastname" name="lastname"  value="'.$row['lastName'].'" type="text">'; ?>
                    <label>Email :</label>
                    <?php echo '<input id="email" name="email" value="'.$row['email'].'" type="text">'; ?>
                    <label>Password :</label>
                    <input id="pass" name="pass" placeholder="**********" type="password">
                    <br />
                    <br />
                    <input name="submit" type="submit" value=" Update ">
                    <br />
                </form>
            </div>
        </div>
        <?php 
                              
        }  
        $conn->close(); ?>
    </body>
</html>
