<?php
    //database connection, located in the config directory
    include('../../../config/database_connection.php');

try{

    //define empty variables
    $chickenBatch_ID = $coopNumber = $dosage = $medicine_ID = $medicine_ID = $methodType = $numberHeads = $administrationSched = $administeredBy = $notes = $status = "";
    
    //variables to store error messages
    $chickenBatch_err = $medicine_ID_err = $dosage_err = $methodType_err = $numberHeads_err = $administrationSched_err = $administeredBy_err = $notes_err = $status_err = "";
    
    //processes the data from the form submitted
    if(isset($_POST['submit'])){

        //collect data from the form and store them in the defined variables
        $scheduleType = 'medication';
        $chickenBatch_ID = $_POST['chickenBatch_ID'];
        $medicine_ID = $_POST['medicine_ID'];
        $methodType = $_POST['methodType'];
        $numberHeads = $_POST['numberHeads'];
        $administrationSched = $_POST['administrationSched'];
        $administeredBy = $_POST['administeredBy'];
        $notes = $_POST['notes'];
        $status = $_POST['status'];
        $dosage = $_POST['dosage'];
    
        //validate chickenBatch ID if empty, display error message. if not empty, use the chickenBatch ID to get the coop number
        if(empty($chickenBatch_ID)){
            $chickenBatch_err = "Please select chicken batch ID";
        }else if(!empty($chickenBatch_ID)){
            //statement to fetch the coopnumber of the chicken batch
            $sql = "SELECT coopNumber FROM chickenproduction WHERE chickenBatch_ID = '$chickenBatch_ID'";
            $stmt = $conn->query($sql);

            if($stmt){
                if($stmt->rowCount() > 0){
                    while($row = $stmt->fetch()){
                        $coopNumber = $row['coopNumber']; //store the coopNUmber
                    }
                    // Free result set
                    unset($stmt);
                } else{
                    $chickenBatch_err = "No records found.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        //validate medicine id if empty, display error.  if not empty, fetch the medicine name according to the medicine id
        if(empty($medicine_ID)){
            $medicine_ID_err = "Please select a medicine";
        }else if(!empty($medicine_ID)){
            //statement to select the  medicine name based on the medicine id given
            $sql = "SELECT medicineName FROM medicines WHERE medicine_ID = '$medicine_ID'";
            $stmt = $conn->query($sql);

            if($stmt){
                if($stmt->rowCount() > 0){
                    while($row = $stmt->fetch()){
                        $medicineName = $row['medicineName']; // store the medicine name
                    }
                    // Free result set
                    unset($stmt);
                } else{
                    $medicine_ID_err = 'No records were found';
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        //validate the number of heads
        if(empty($numberHeads)){
            $numberHeads_err = "Please enter number of heads";
        }
        else if($numberHeads < 1){ //if the head is lesser than 1 then display error
            $numberHeads_err = "Please enter valid number of heads";
        }

        //validate dosage
        if(empty($dosage)){
            $dosage_err = "Please enter dosage";
        }
        else if($dosage < 1){ //if the dosage is lesser than 1 then display error
            $dosage_err = "Please enter valid dosage";
        }

        //validate methodType if empty, display error
        if(empty($methodType)){
            $methodType_err = "Please select medication type";
        }

        //validate medicine administration schedule if empty, display error
        if(empty($administrationSched)){
            $administrationSched_err = "Please enter administration schedule";
        }

        //validate status if empty, display error
        if(empty($status)){
            $status_err = "Please enter status";
        }

        //validate administered by if empty, display error
        if(empty($administeredBy)){
            $administeredBy_err = "Please select an mployee";
        }

        //validate notes
        if(empty($notes)){ //notes is optional, if notes is empty. this will use the value 'no note'
            $notes = "no notes.";
        }
        else if(strlen(trim($notes)) > 100){ //this will count the length of the note, if note is greater than 100 characters, display error
            $notes_err = "Note exceed 100 character limit.";
        }

        //if the error variables is empty then the data will be save to the database
        if(empty($chickenBatch_err) && empty($medicine_ID_err) && empty($methodType_err) && empty($administrationSched_err) && empty($status_err) && empty($numberHeads_err) && empty($administeredBy_err) && empty($notes_err)){

           // Prepare an insert statement
           $sql = "INSERT INTO schedules (scheduleType, chickenBatch_ID, coopNumber, medicine_ID, medicineName, methodType, dosage, numberHeads, administrationSched, administeredBy, status, notes) VALUES (:scheduleType, :chickenBatch_ID, :coopNumber, :medicine_ID, :medicineName, :methodType, :dosage, :numberHeads, :administrationSched, :administeredBy, :status, :notes)";
         
           if($stmt = $conn->prepare($sql))
           {
               // Bind variables to the prepared statement as parameters
               $stmt->bindParam(":scheduleType", $param_scheduleType, PDO::PARAM_STR);
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
               $param_scheduleType = $scheduleType;
               $param_chickenBatch_ID = $chickenBatch_ID;
               $param_coopNumber = $coopNumber;
               $param_medicine_ID = $medicine_ID;
               $param_medicineName = $medicineName;
               $param_dosage = $dosage;
               $param_numberHeads = $numberHeads;
               $param_methodType = $methodType;
               $param_administrationSched = $administrationSched;
               $param_administeredBy = $administeredBy;
               $param_status = $status;
               $param_notes = $notes;

               // Attempt to execute the prepared statement
               if($stmt->execute())
               {
               //$success = "Medicine successfully saved."; //this will be use to flash a message to the user that the medicine issave //maybe we could use $_SESSION['success'] = messae here
                header('Location: medication_pending.php'); // if the data is valid and successful save, this will redirect user to the pending schedules
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