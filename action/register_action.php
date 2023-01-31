<?php
//database connection, located in the config directory
include('config/database_connection.php');

try{

    //define empty variables
    $fname = $lname = $contact_num = $role = $username = $password = $confirm_password =  $success = "";
    
    //variables to store error messages
    $fname_err = $lname_err = $contact_num_err = $role_err = $username_err = $password_err = $confirm_password_err = "";
    
    //processes the data from the form submitted
    if(isset($_POST['submit'])){

        //collect data from the form and store them in the defined variables
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $contact_num = $_POST['contact_num'];
        $role = $_POST['role'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
    
    
        //validate first name if empty and only allows only alphabets and white spaces
        if (!preg_match('/^[\p{L} ]+$/u', trim($fname)) ) {  
           $fname_err = "Only alphabets and whitespace are allowed.";
        }
        else if (empty(trim($fname))) {  
            $fname_err = "Please enter first name.";
        }
        else if(strlen(trim($fname)) > 50){
            $fname_err = "First Name should not exceed more than 50 characters.";
        }
        
        //validate last name if empty and allows only alphabets and white spaces
        if (!preg_match('/^[\p{L} ]+$/u', $lname) ) {  
            $lname_err = "Only alphabets and whitespace are allowed."; 
        }
        else if (empty(trim($lname))) {  
            $lname_err = "Please enter last name.";
        }
        else if(strlen(trim($lname)) > 50){
            $lname_err = "Last Name should not exceed more than 50 characters.";
        }
    
        //validate contact_number if empty and only allows number with a length of 11, validate if number exist then display error
        if (!preg_match ("/^[0-9]*$/", $contact_num) ){  
            $contact_num_err = "Please enter a valid mobile number."; 
        }
        else if (empty(trim($contact_num))) {
            $contact_num_err = "Please enter a mobile number";
        }
        else if (strlen(trim($contact_num)) < 11 || strlen(trim($contact_num)) > 11){
            $contact_num_err = "Please enter 11 digits mobile number.";
        }
        else{ 
            //this will validate if the mobile number exist in the database
            // Prepare a select statement to check if contact number already exists
            $sql = "SELECT contact_num FROM users WHERE contact_num = :contact_num";
        
            if($stmt = $conn->prepare($sql))
            {
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":contact_num", $param_contact_num, PDO::PARAM_STR);
            
                // Set parameters
                $param_contact_num = trim($_POST["contact_num"]);
            
                // Attempt to execute the prepared statement
                if($stmt->execute()){
                    if($stmt->rowCount() == 1){
                    $contact_num_err = "Mobile Number is already taken.";
                    } 
                } 
                else{
                    echo "Oops! Something went wrong. Please try again later.";
                }

                // Close statement
                unset($stmt);
             }
        }

        //validate role
        if (empty($role)){
            $role_err = "Please select a role";
        }

        //validate username
        if (empty(trim(($username)))) {
            $username_err = "Please enter a username.";
        }
        else if(strlen(trim($username)) > 50){
            $username_err = "Username should not exceed more than 50 characters.";
        }
        else{
            //this will validate if the username already exist in the database
            // Prepare a select statement to check if username already exists
            $sql = "SELECT username FROM users WHERE username = :username";
        
            if($stmt = $conn->prepare($sql))
            {
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            
                // Set parameters
                $param_username = trim($_POST["username"]);
            
                // Attempt to execute the prepared statement
                if($stmt->execute()){
                    if($stmt->rowCount() == 1){
                    $username_err = "This username is already taken.";
                    } 
                } 
                else{
                    echo "Oops! Something went wrong. Please try again later.";
                }

                // Close statement
                unset($stmt);
             }
        }
        
        //validate password if empty and only accepts equals or more than 6 characters
        if(empty(trim($password))){
            $password_err = "Please enter password";
        }
        else if (strlen(trim($password)) < 6){
            $password_err = "Password must have atleast 6 characters.";
        }

        //validate confirm password if empty and if match the password
        if(empty(trim($confirm_password))){
            $confirm_password_err = "Please confirm password.";     
        }
        else{
            $confirm_password = trim($confirm_password);
            if(empty($password_err) && ($password !== $confirm_password)){
                $confirm_password_err = "Password did not match.";
            }
        }

        //if the error variables is empty then the data will be save to the database
        if(empty($fname_err) && empty($lname_err) && empty($contact_num_err) && empty($role_err) && empty($username_err) && empty($password_err) && empty($confirm_password_err)){

           // Prepare an insert statement
           $sql = "INSERT INTO users (fname, lname, contact_num, role, username, password) VALUES (:fname, :lname, :contact_num, :role, :username, :password)";
         
           if($stmt = $conn->prepare($sql))
           {
               // Bind variables to the prepared statement as parameters
               $stmt->bindParam(":fname", $param_fname, PDO::PARAM_STR);
               $stmt->bindParam(":lname", $param_lname, PDO::PARAM_STR);
               $stmt->bindParam(":contact_num", $param_contact_num, PDO::PARAM_STR);
               $stmt->bindParam(":role", $param_role, PDO::PARAM_STR);
               $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
               $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);

               // Set parameters
               $param_fname = $fname;
               $param_lname = $lname;
               $param_contact_num = $contact_num;
               $param_role = $role;
               $param_username = $username;
               $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
               // Attempt to execute the prepared statement
               if($stmt->execute())
               {
                $success = "User successfully created."; //this will be used in flashing a message to the user that a new user is registered
               } 
               else
               {
               echo "Something went wrong. Please try again later.";
               }

               // Close statement
               unset($stmt);
           }
        }
    
    }
    

}catch(PDOException $e){
    echo ("Error: " . $e->getMessage());
}
?>