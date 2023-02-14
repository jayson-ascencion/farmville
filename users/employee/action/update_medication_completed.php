<?php
    //database connection, located in the config directory
    include('../../../config/database_connection.php');

    try{

        //define empty variables
        $status = "";
        
        //variables to store error messages
        $status_err = "";
        
        //processes the data from the form submitted
        if(isset($_POST['updateMedication'])){
            
            //this is an administration id, passed from the previous page
            $id = $_REQUEST['id'];

            //collect data from the form and store them in the defined variables
            $status = $_POST['status'];

            //validate status
            if(empty($status)){
                $status_err = "Please enter status";
            }

            //if the error variables is empty then the data will be save to the database
            if(empty($status_err)){

                // Prepare an insert statement
                $sql = "UPDATE schedules SET status=:status WHERE administration_ID = '$id'";
                
                if($stmt = $conn->prepare($sql))
                {
                    // Bind variables to the prepared statement as parameters
                    $stmt->bindParam(":status", $param_status, PDO::PARAM_STR);

                    // Set parameters
                    $param_status = $status;

                    // Attempt to execute the prepared statement
                    if($stmt->execute())
                    {
                        $_SESSION['status'] = "Schedule Updated Successfully."; 
                        header('Location: medication_completed.php');
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