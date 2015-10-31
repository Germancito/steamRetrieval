<?php
   
include 'testRabbitMQClient.php';
     //echo"this is working";
    // Get Posted form values
    // Note that whatever is enclosed by $_POST[""] matches the form input elements
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $steamid = $_POST["steamid"];
    $email = $_POST["email"];
    $pass = $_POST["pass"];
    
    echo$steamid;
    //let's check if all fields are filled
    if($firstname == "" ||
        $lastname == "" ||
        $steamid == "" ||
        $email == "" ||
        $pass == "")
        {
            //if all fields are blank, print message and stop the program with the "exit" command.
            echo "<font color='red'><b>Sorry, all the fields must be informed.</b></font>";
            //exit;
        }
	
	//send("add",$steamid); 
	send("popFri",$steamid);
	//send("populateFriends");
  
    // Connect to our DB with mysqli(<server>, <username>, <password>, <database>)
    $sql_connection = mysqli_connect("localhost", "root", "password", "profile");

     
    //check if the connection was made
	if (!mysqli_ping($sql_connection)) 
			{
		    		echo 'Lost connection, exiting after query #1';
		    		exit;
			}
   
  	
	//echo "the connection works!"
	/*
  	$check="SELECT * from tbluser where steamid=$steamid;"
	$checkID=mysqli_query($sql_connection,$check);
	if(mysqli_num_rows($query_id1)=0){
		echo "<font color='red'><b>The steamid already exits.</b></font>";
            	exit;	
	}
		
	*/
        $encrypted_pass = base64_encode($pass);
         
        //the instruction bellow will save the data to your database
        $sql = "INSERT INTO tbluser (firstname,lastname,steamid,email,pass) VALUES ('$firstname','$lastname','$steamid','$email','$encrypted_pass')";
         
        //execute the SQL instruction
        mysqli_query($sql_connection, $sql);
        
        $query = mysqli_query($sql_connection, "select * from tbluser where email='$email'" );
        $rows = mysqli_num_rows($query);
        if ($rows > 0) 
        {
            //echo $rows;
            $_SESSION['login_user']=$email; // Initializing Session
            header("location: profile.php"); // Redirecting To Other Page
        } 
         
     
     
?>
