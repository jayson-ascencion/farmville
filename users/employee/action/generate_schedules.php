<?php
//if age is greater or equals than 0 and age is lesser than or equals to 60
if($age >= 0 && $age <= 60){

    $sql = "SELECT * FROM generateschedules";
    $stmt = $conn->query($sql);
    if($stmt){
        if($stmt->rowCount() > 0){
            while($row = $stmt->fetch()){
                $age = $row['age'];
                $medicine_ID = $row['medicine_ID'];
                $medicineName = $row['medicineName'];
                $method = $row['method'];
                $scheduleType = $row['type'];
            }
            // Free result set
            unset($result);
        } else{
            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
        }
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }
    unset($pdo);

    //chekc if the age is 0, if 0, generate all scheds. if not 0, chek the the age and generate sched depending on the 
    if($age == 0){
        if($age == 0){
            $counter = 0;
            for($counter = 0; $counter <= 3; $counter++){
                // Prepare an insert statement
                $sql = "INSERT INTO schedules (scheduleType, chickenBatch_ID, coopNumber, medicine_ID, medicineName, methodType, dosage, numberHeads, administrationSched, administeredBy, status, notes) VALUES (:scheduleType, '18', '10', :medicine_ID, :medicineName, :methodType, '1', '1', '2023-01-01', '20', 'pending', 'no notes')";
         
           if($stmt = $conn->prepare($sql))
           {
               // Attempt to execute the prepared statement
               if($stmt->execute())
               {
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
    }
    else{

    }

}
