<?php
    // Get Posted form values
    // Note that whatever is enclosed by $_POST[""] matches the form input elements
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $pass = $_POST["pass"];
     
    //let's check if all fields are filled
    if($firstname == "" ||
        $lastname == "" ||
        $pass == "")
        {
            //if all fields are blank, print message and stop the program with the "exit" command.
            echo "<font color='red'><b>Sorry, all the fields must be informed.</b></font>";
            exit;
        }
  
    // Connect to our DB with mysqli(<server>, <username>, <password>, <database>)
    $sql_connection = new mysqli("localhost", "root", "root", "test");
     
    //check if the connection was made
    if($sql_connection == true)
    {
  
  
        $encrypted_pass = base64_encode($pass);
         
        //the instruction bellow will save the data to your database
        $sql = "update tbluser  set
                    firstName =  '$firstname',
                    lastName = '$lastname',
                    pass = '$encrypted_pass'
                    where email = '$email' ";
         
        //execute the SQL instruction
        if ($sql_connection->query($sql) === TRUE) 
        {       
            echo "Record updated successfully";
        }
             
        $sql_connection->close();
         
        header("location: profile.php");
    }
    else
    {
        //if something goes wrong in connection, print a message on screen
        echo "<font color='red'><b>Connection error: The data wasn't saved.</b></font>";
    }
     
?>
