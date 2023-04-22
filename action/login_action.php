<?php
//database connection, located in the config directory
include('./config/database_connection.php');

//starts the session
session_start();

try{
    // Check if the user is already logged in, if yes then redirect user to designated page or redirect user to previous page
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        
        if($_SESSION["role"] === 1){
            //page for manager
            header("location:users/manager/views/index.php");
        }
        else if ($_SESSION["role"] === 2){
            //page for administrator
            header("location:users/admin/views/index.php");
        }
        else if ($_SESSION["role"] === 3){
            //page for employee
            header("location:users/employee/views/index.php");
        }
        else{
            //if user tries to access a page without logging in, redirect user to login page
            header("Location: login.php");
        }
    }
    
    //define empty variables
    $username = $password = $role = "";

    //define error variables
    $username_err = $password_err = $login_err = "";
    
    // processes the data when the form is submitted from login page
    if(isset($_POST['submit'])){
        
        //collects data from the form
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Check if username is empty
        if(empty(trim($username))){
            $username_err = "Please enter username.";
        } else{
            $username = trim($username);
        }
        
        // Check if password is empty
        if(empty(trim($password))){
            $password_err = "Please enter your password.";
        } else{
            $password = trim($password);
        }
        
        //if validation error variables are empty then proceed to validating user if username exist in the database
        if(empty($username_err) && empty($password_err)){
            // Prepare a select statement
            $sql = "SELECT user_ID, status, role, username, password FROM users WHERE username = :username";
            
            if($stmt = $conn->prepare($sql)){
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
                
                // Set parameters
                $param_username = trim($username);
                
                // Attempt to execute the prepared statement
                if($stmt->execute()){
                    // Check if username exists, if yes then verify password
                    if($stmt->rowCount() == 1){
                        if($row = $stmt->fetch()){
                            $user_ID = $row["user_ID"];
                            $status = $row["status"];
                            $role = $row["role"];
                            $username = $row["username"];
                            $hashed_password = $row["password"];
                            if($username !== $_POST['username']){
                                
                                //check if username exist in the database
                                $login_err = "Invalid username or password.";
                            }
                            else if($status !== 'active'){
                                $login_err = "<strong> Your account is disabled.</strong> Contact administrator for support.";
                            }
                            else if(password_verify($password, $hashed_password)){
                                // Password is correct, so start a new session
                                session_start();
                                
                                // Store data in session variables, to be use in different pages for displaying data
                                $_SESSION["loggedin"] = true;
                                $_SESSION["user_ID"] = $user_ID;
                                $_SESSION["role"] = $role;
                                $_SESSION["username"] = $username;                            
                                $_SESSION['insertSuccess'] = "";
                                // Redirect user to landing page
                                if($_SESSION["role"] == 1){
                                    header("Location: users/manager/views/index.php");
                                }
                                else if ($_SESSION["role"] == 2){
                                    header("Location: users/admin/views/index.php");
                                }
                                else if ($_SESSION["role"] == 3){
                                    header("Location: users/employee/views/index.php");
                                }
                            }
                            else{
                                // Password is not valid, display a generic error message
                                $login_err = "Invalid username or password.";
                            }
                        }
                    } else{
                        // Username doesn't exist, display a generic error message
                        $login_err = "Invalid username or password.";
                    }
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }

                // Close statement
                unset($stmt);
            }
        }
        
        // Close connection
        unset($conn);
    }

}catch(PDOException $e){
    echo ("Error: " . $e->getMessage());
}
?>