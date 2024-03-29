<?php
    //database connection, located in the config directory
    include('../../../config/database_connection.php');

try{

    //define empty variables
    $chickenBatch_ID = $coopNumber = $dosage = $medicine_ID = $medicine_ID = $methodType = $numberHeads = $administrationSched = $administeredBy = $notes = $status = "";
    
    //variables to store error messages
    $chickenBatch_err = $medicine_ID_err = $dosage_err = $methodType_err = $numberHeads_err = $administrationSched_err = $administeredBy_err = $notes_err = $status_err = "";
    
    //processes the data from the form submitted
    if(isset($_POST['updateVaccination'])){

        //this is an administration id passeed  from the previous page and will be use in update the record
        $id = $_REQUEST['id'];

        //collect data from the form and store them in the defined variables
        $updateType = $_POST['update_type'];
        $chickenBatch_ID = $_POST['chickenBatch_ID'];
        $medicine_ID = $_POST['medicine_ID'];
        $methodType = $_POST['methodType'];
        $numberHeads = $_POST['numberHeads'];
        $administrationSched = $_POST['administrationSched'];
        $administeredBy = $_POST['administeredBy'];
        $notes = $_POST['notes'];
        $status = $_POST['status'];
        $dosage = $_POST['dosage'];
    
        //validate chickenBatch ID
        if(empty($chickenBatch_ID)){
            $chickenBatch_err = "Please select chicken batch ID";
        }else if(!empty($chickenBatch_ID)){
            //statement to select the coopnumber
            $sql = "SELECT coopNumber FROM chickenproduction WHERE chickenBatch_ID = '$chickenBatch_ID'";
            $stmt = $conn->query($sql);

            if($stmt){
                if($stmt->rowCount() > 0){
                    while($row = $stmt->fetch()){
                        $coopNumber = $row['coopNumber']; //stores the coopnumber
                    }
                    // Free result set
                    unset($stmt);
                } else{
                    echo '<div class="alert alert-danger"><em>No records gfgffg were found.</em></div>';
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        //validate medicine id and if not empty, fetch the medicine id
        if(empty($medicine_ID)){
            $medicine_ID_err = "Please select a medicine";
        }else if(!empty($medicine_ID)){
            //statement to select  the medicine names
            $sql = "SELECT medicineName FROM medicines WHERE medicine_ID = '$medicine_ID'";
            $stmt = $conn->query($sql);

            if($stmt){
                if($stmt->rowCount() > 0){
                    while($row = $stmt->fetch()){
                        $medicineName = $row['medicineName']; //stores the medicine name
                    }
                    // Free result set
                    unset($stmt);
                } else{
                    echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        //validate number of heads
        if(empty($numberHeads)){
            $numberHeads_err = "Please enter number of heads";
        }
        else if($numberHeads < 1){ //if the number of head is lesser than 1, display error
            $numberHeads_err = "Please enter valid number of heads";
        }

        //validate dosage
        if(empty($dosage)){
            $dosage_err = "Please enter dosage";
        }
        else if($dosage < 1){ //if the dosage is lesser than 1, display error
            $dosage_err = "Please enter valid dosage";
        }

        //validate methodType
        if(empty($methodType)){
            $methodType_err = "Please select medication type";
        }

        //validate medicine administration schedule
        if(empty($administrationSched)){
            $administrationSched_err = "Please enter administration schedule";
        }

        //validate status
        if(empty($status)){
            $status_err = "Please enter status";
        }

        //validate administered by
        if(empty($administeredBy)){
            $administeredBy_err = "Please select an mployee";
        }

        //validate notes
        if(empty($notes)){
            $notes = "no notes.";
        }
        else if(strlen(trim($notes)) > 100){ //if the length of the notes is greater than 100, display error
            $notes_err = "Note exceed 100 character limit.";
        }

        //if the error variables is empty then the data will be save to the database
        if(empty($chickenBatch_err) && empty($medicine_ID_err) && empty($dosage_err) && empty($methodType_err) && empty($administrationSched_err) && empty($status_err) && empty($numberHeads_err) && empty($administeredBy_err) && empty($notes_err)){

           // Prepare an insert statement
           $sql = "UPDATE schedules SET chickenBatch_ID=:chickenBatch_ID, coopNumber=:coopNumber, medicine_ID=:medicine_ID, medicineName=:medicineName, methodType=:methodType, dosage=:dosage, numberHeads=:numberHeads, administrationSched=:administrationSched, administeredBy=:administeredBy, status=:status, notes=:notes WHERE administration_ID = '$id'";
         
           if($stmt = $conn->prepare($sql))
           {
               // Bind variables to the prepared statement as parameters
               $stmt->bindParam(":chickenBatch_ID", $param_chickenBatch_ID, PDO::PARAM_STR);
               $stmt->bindParam(":coopNumber", $param_coopNumber, PDO::PARAM_STR);
               $stmt->bindParam(":medicine_ID", $param_medicine_ID, PDO::PARAM_STR);
               $stmt->bindParam(":medicineName", $param_medicineName, PDO::PARAM_STR);
               $stmt->bindParam(":methodType", $param_methodType, PDO::PARAM_STR);
               $stmt->bindParam(":dosage", $param_dosage, PDO::PARAM_STR);
               $stmt->bindParam(":numberHeads", $param_numberHeads, PDO::PARAM_STR);
               $stmt->bindParam(":administrationSched", $param_administrationSched, PDO::PARAM_STR);
               $stmt->bindParam(":administeredBy", $param_administeredBy, PDO::PARAM_STR);
               $stmt->bindParam(":status", $param_status, PDO::PARAM_STR);
               $stmt->bindParam(":notes", $param_notes, PDO::PARAM_STR);

               // Set parameters
               $param_chickenBatch_ID = $chickenBatch_ID;
               $param_coopNumber = $coopNumber;
               $param_medicine_ID = $medicine_ID;
               $param_medicineName = $medicineName;
               $param_methodType = $methodType;
               $param_dosage = $dosage;
               $param_numberHeads = $numberHeads;
               $param_administrationSched = $administrationSched;
               $param_administeredBy = $administeredBy;
               $param_status = $status;
               $param_notes = $notes;
               // Attempt to execute the prepared statement
               if($stmt->execute())
               {
                    $_SESSION['status'] = "Schedule Updated Successfully."; 
                    if($updateType === 'pending'){

                        header('Location: vaccination_pending.php');
                    }else{

                        header('Location: vaccination_completed.php');
                    }
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