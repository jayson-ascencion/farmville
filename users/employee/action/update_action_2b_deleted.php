<?php
    try{

        //define data variables
        $status = $success = "";
        
        //variables to store error message
        $status_err = "";

        //process the form if button is clicked
        if(isset($_POST['updateStatus'])){
            if(!empty($_POST['status'])){
                //collect data from the form
                $status = $_POST['status'];
                $id = $_POST['id'];

                //validate status if empty
                if (empty($status)){
                    $status_err = "Please select a status";
                    //return $id = $_POST['id'];
                }

                if(empty($status_err)){
                    //connect to the database 
                    include('../../../config/database_connection.php');


                // Prepare an insert statement
                $sql = "UPDATE medicineadministration SET status=:status WHERE administration_ID = :id";
                
                if($stmt = $conn->prepare($sql))
                {
                    // Bind variables to the prepared statement as parameters
                    $stmt->bindParam(":status", $param_status, PDO::PARAM_STR);
                    $stmt->bindParam(":id", $param_id, PDO::PARAM_STR);

                    // Set parameters
                    $param_status = $status;
                    $param_id= $id;

                    // Attempt to execute the prepared statement
                    if($stmt->execute())
                    {
                        if($status==='completed'){
                            $success = "Status updated to " . $status;
                            header("Location: completed_schedules.php");
                        }else{
                            $success = "Status updated to " . $status;
                            header("Location: pending_schedules.php");
                            
                        }
                        ob_end_flush();
                    } 
                    else
                    {
                    echo "Something went wrong. Please try again later.";
                    }

                    // Close statement
                    unset($stmt);
                }
                }
            
            }else{
                $status_err = "Please select a status";
            }

        }
        

    }catch(PDOException $e){
        echo ("Error: " . $e->getMessage());
    }
?>