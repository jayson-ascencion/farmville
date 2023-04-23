<?php
    //database connection, located in the config directory
    include('../../../config/database_connection.php');

try{

    //define empty variables
    $fname = $lname = $new_contact_num = $role = $new_username = $status = $old_contact = $old_username = "";
    
    //variables to store error messages
    $fname_err = $lname_err = $new_contact_num_err = $role_err = $new_username_err = $status_err = "";
    
    //processes the data from the form submitted
    if(isset($_POST['submit'])){

        //this is an administration id passeed  from the previous page and will be use in update the record
        $id = $_REQUEST['id'];

                            
        //statement to select the specific schedule to update
        $sql = "SELECT * FROM users WHERE user_ID = '$id'";
        $stmt = $conn->query($sql);
        if($stmt){
            if($stmt->rowCount() > 0){
                while($row = $stmt->fetch()){
                $old_contact = $row['contact_num'];
                $old_username = $row['username'];
                }
                // Free result set
                unset($result);
            } else{
                echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
            }
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
        unset($stmt);
         
        //collect data from the form and store them in the defined variables
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $new_contact_num = $_POST['new_contact_num'];
        $role = $_POST['role'];
        $new_username = $_POST['new_username'];
        $status = $_POST['status'];

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
         if (!preg_match ("/^[0-9]+$/", $new_contact_num) ){  
            $new_contact_num_err = "Please enter a valid mobile number."; 
         }
         else if (empty(trim($new_contact_num))) {
            $new_contact_num_err = "Please enter a mobile number";
         }
         else if (strlen(trim($new_contact_num)) < 11 || strlen(trim($new_contact_num)) > 11){
            $new_contact_num_err = "Please enter 11 digits mobile number.";
         }
         else if(!empty($new_contact_num)){ 
            if($new_contact_num != $old_contact){
                $sql = "SELECT contact_num FROM users WHERE contact_num = :new_contact_num";
            
                if($stmt = $conn->prepare($sql))
                {
                    // Bind variables to the prepared statement as parameters
                    $stmt->bindParam(":new_contact_num", $param_contact_num, PDO::PARAM_STR);
                
                    // Set parameters
                    $param_contact_num = trim($_POST["new_contact_num"]);
                
                    // Attempt to execute the prepared statement
                    if($stmt->execute()){
                        if($stmt->rowCount() == 1){

                        $new_contact_num_err = "Mobile Number is already taken.";
                        } 
                    } 
                    else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }

                    // Close statement
                    unset($stmt);
                }
            }
         }
 
         //validate role
         if (empty($role)){
            $role_err = "Please select a role";
         }
 
         //validate username
         if (empty(trim(($new_username)))) {
            $new_username_err = "Please enter a username.";
         }
         else if(strlen(trim($new_username)) > 50){
            $new_username_err = "Username should not exceed more than 50 characters.";
         }
         else{
            if($new_username != $old_username){
                //this will validate if the username already exist in the database
                // Prepare a select statement to check if username already exists
                $sql = "SELECT username FROM users WHERE username = :new_username";
            
                if($stmt = $conn->prepare($sql))
                {
                    // Bind variables to the prepared statement as parameters
                    $stmt->bindParam(":new_username", $param_username, PDO::PARAM_STR);
                
                    // Set parameters
                    $param_username = trim($_POST["new_username"]);
                
                    // Attempt to execute the prepared statement
                    if($stmt->execute()){
                        if($stmt->rowCount() == 1){
                        $new_username_err = "This username is already taken.";
                        } 
                    } 
                    else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }

                    // Close statement
                    unset($stmt);
                }
            }
         }

        //validate status
        if(empty($status)){
            $status = "no status.";
        }

        //if the error variables is empty then the data will be save to the database
        if(empty($fname_err) && empty($lname_err) && empty($new_contact_num_err) && empty($role_err) && empty($new_username_err) && empty($status_err)){

           // Prepare an insert statement
           $sql = "UPDATE users SET fname=:fname, lname=:lname, contact_num=:new_contact_num, role=:role, username=:new_username, status=:status, status=:status WHERE user_ID = '$id'";
         
           if($stmt = $conn->prepare($sql))
           {
               // Bind variables to the prepared statement as parameters
               $stmt->bindParam(":fname", $param_fname, PDO::PARAM_STR);
               $stmt->bindParam(":lname", $param_lname, PDO::PARAM_STR);
               $stmt->bindParam(":new_contact_num", $param_new_contact_num, PDO::PARAM_STR);
               $stmt->bindParam(":role", $param_role, PDO::PARAM_STR);
               $stmt->bindParam(":new_username", $param_new_username, PDO::PARAM_STR);
               $stmt->bindParam(":status", $param_status, PDO::PARAM_STR);

               // Set parameters
               $param_fname = $fname;
               $param_lname = $lname;
               $param_new_contact_num = $new_contact_num;
               $param_role = $role;
               $param_new_username = $new_username;
               $param_status = $status;
               // Attempt to execute the prepared statement
               if($stmt->execute())
               {
                    $_SESSION['status'] = "User Successully Updated"; 
                    header('Location: users.php');
                    
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