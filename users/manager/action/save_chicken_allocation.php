<?php
//database connection, located in the config directory
include('../../../config/database_connection.php');

try{

    //define variables
    $age = $coopNumber = $batchName = $breedType = $sex = $quantity = $batchPurpose = $inStock = $dateAcquired =  $acquisitionType = $note = "";

    //variables to store error message
    $age_err = $coopNumber_err = $batchName_err = $breedType_err = $sex_err = $quantity_err = $batchPurpose_err = $startingQuantity_err = $inStock_err = $dateAcquired_err = $acquisitionType_err = $note_err = "";
    
    //processing the data from the form submitted
    if(isset($_POST['submit'])){

        //collect data from the form
        // $age = $_POST['age'];
        $coopNumber = $_POST['coopNumber'];
        // $batchName = $_POST['batchName'];
        // $breedType = $_POST['breedType'];
        $sex = $_POST['sex'];
        $quantity = $_POST['quantity'];
        $dispositionType = 'allocation';
        // $batchPurpose = $_POST['batchPurpose'];
        // $startingQuantity = $_POST['startingQuantity'];
        $dateAcquired = $_POST['dateAcquired'];
        // $acquisitionType = $_POST['acquisitionType'];
        $note = $_POST['note'];
        $user_ID = $_SESSION['user_ID'];

        //validate age if empty
        // if (!preg_match("/^[0-9]+$/", $age) ){  
        //     $age_err = "Please enter a valid age."; 
        // }
        // else if(empty($age)){
        //     $age_err = "Please enter age";
        // }
 
        //validate coop number and only accept numeric input
        if (!preg_match ("/^[0-9]*$/", trim($coopNumber)) ) {  
           $coopNumber_err = "Please enter a valid coop number.";
        }
        else if (empty(trim($coopNumber))) {  
            $coopNumber_err = "Please enter coop number.";
        }
        else if (!empty($coopNumber)) {
            // Prepare a select statement to check if coopNumber already exists
            // $sql = "SELECT coopNumber FROM chickenproduction WHERE coopNumber = :coopNumber";
            // $stmt = $conn->prepare($sql);
            // $stmt->bindParam(":coopNumber", $coopNumber, PDO::PARAM_STR);
          
            // // Attempt to execute the prepared statement
            // if ($stmt->execute()) {
            //   if ($stmt->rowCount() > 0) {
            //     $coopNumber_err = "This coopNumber already exists.";
            //   }
            // } else {
            //   echo "Oops! Something went wrong. Please try again later.";
            // }

            $sql = "SELECT batchName, chickenBatch_ID FROM chickenproduction WHERE coopNumber = $coopNumber";
            $stmt = $conn->query($sql);
            if($stmt){
                if($stmt->rowCount() > 0){
                    while($row = $stmt->fetch()){
                        $batchName = $row['batchName'];
                        $chickenBatch_ID = $row['chickenBatch_ID'];
                    }
                }
            }
        }
        //---------------------------------------
        //validate medicine name if empty and allows only alphabets and white spaces
        // if (empty(trim($batchName))) {  
        //     $batchName_err = "Please enter batch name.";
        // }

        //validate breed type if empty and allows only alphabets and white spaces
        // if (empty(trim($breedType))) {  
        //     $breedType_err = "Please select breed type.";
        // }

        //validate batchPurpose
        // if (empty($batchPurpose)){
        //     $batchPurpose_err = "Please select batch purpose";
        // }

        //validate smale if empty
        // if (!preg_match ("/^[0-9]+$/", $sex) ){  
        //     $sex_err = "Please enter a valid quantity."; 
        // }
        // else if(empty($sex)){
        //     $sex_err = "Please enter a quantity";
        // }

        //validate sfemale  if empty
        if (!preg_match ("/^[0-9]+$/", $quantity) ){  
            $quantity_err = "Please enter a valid quantity."; 
        }
        else if(empty($quantity)){
            $quantity_err = "Please enter a quantity";
        }
        
        // $inStock = $sex + $quantity;
        
        //validate starting quantity if empty
        if (empty($dateAcquired) ){  
            $dateAcquired_err = "Please enter date acquired."; 
        }
        
        //validate starting quantity if empty
        if (empty($sex) ){  
            $sex_err = "Please select a sex."; 
        }
        //validate acquisitionType
        // if (empty($acquisitionType)){
        //     $acquisitionType_err = "Please select acquisition type";
        // }

        //validate note
        if(empty($note)){
            $note = "no note.";
        }else if(strlen(trim($note)) > 100){
            $note_err = "Note exceeded the 100 characters limit.";
        }


        if(empty($coopNumber_err) && empty($batchName_err) && empty($sex_err) && empty($quantity_err) && empty($dateAcquired_err) && empty($note_err)){

           // Prepare an insert statement
           $sql = "INSERT INTO chickentransaction (coopNumber, batchName, sex, quantity, dispositionType, transactionDate, note, user_ID, chickenBatch_ID) VALUES (:coopNumber, :batchName, :sex, :quantity, :dispositionType, :dateAcquired, :note, :user_ID, :chickenBatch_ID)";
         
           if($stmt = $conn->prepare($sql))
           {
               // Bind variables to the prepared statement as parameters
            //    $stmt->bindParam(":age", $param_age, PDO::PARAM_STR);
               $stmt->bindParam(":coopNumber", $param_coopNumber, PDO::PARAM_STR);
               $stmt->bindParam(":batchName", $param_batchName, PDO::PARAM_STR);
               $stmt->bindParam(":sex", $param_sex, PDO::PARAM_STR);
            //    $stmt->bindParam(":breedType", $param_breedType, PDO::PARAM_STR);
            //    $stmt->bindParam(":batchPurpose", $param_batchPurpose, PDO::PARAM_STR);
            //    $stmt->bindParam(":sex", $param_male, PDO::PARAM_STR);
               $stmt->bindParam(":quantity", $param_quantity, PDO::PARAM_STR);
               $stmt->bindParam(":dispositionType", $param_dispositionType, PDO::PARAM_STR);
            //    $stmt->bindParam(":startingQuantity", $param_startingQuantity, PDO::PARAM_STR);
            //    $stmt->bindParam(":inStock", $param_inStock, PDO::PARAM_STR);
               $stmt->bindParam(":dateAcquired", $param_dateAcquired, PDO::PARAM_STR);
            //    $stmt->bindParam(":acquisitionType", $param_acquisitionType, PDO::PARAM_STR);
               $stmt->bindParam(":note", $param_note, PDO::PARAM_STR);
               $stmt->bindParam(":user_ID", $param_user_ID, PDO::PARAM_STR);
               $stmt->bindParam(":chickenBatch_ID", $param_chickenBatch_ID, PDO::PARAM_STR);

               // Set parameters
            //    $param_age = $age;
               $param_coopNumber = $coopNumber;
               $param_batchName = $batchName;
               $param_sex = $sex;
            //    $param_breedType = $breedType;
            //    $param_batchPurpose = $batchPurpose;
            //    $param_male = $sex;
               $param_quantity = $quantity;
               $param_dispositionType = $dispositionType;
            //    $param_startingQuantity = $startingQuantity;
            //    $param_inStock = $inStock;
               $param_dateAcquired = $dateAcquired;
            //    $param_acquisitionType = $acquisitionType;
               $param_note = $note;
               $param_user_ID = $user_ID;
               $param_chickenBatch_ID = $chickenBatch_ID;
               // Attempt to execute the prepared statement
               if($stmt->execute())
               {    
                    // $chickenAge = $age;
                    // $dosage = 1;
                    // $status = 'pending';
                    // $newnote = '*This schedule is auto-generated';
                    // $scheduleType = 'vaccination';
                    // // Retrieve the chickenbatchid base on the submitted coopnumber for a particular user
                    // $getBatchId = "SELECT chickenBatch_ID FROM chickenproduction WHERE coopNumber = $coopNumber";
                    // $stmt = $conn->prepare($getBatchId);
                    // $stmt->execute();
                    // //store the chickenbatchid here
                    // $BatchID = $stmt->fetch(PDO::FETCH_ASSOC);

                    // // Initialize the counter variable to be used in accessing user id
                    // $counter = 0;

                    // // Initialize the $stmt variable to null
                    // $stmt = null;

                    // // Retrieve the user IDs from the users table where role is employee
                    // $userstmt = $conn->query("SELECT user_ID FROM users WHERE role = 3");
                    // $user_ids = $userstmt->fetchAll(PDO::FETCH_COLUMN);
                    
                    // // set the stmt according to the age
                    // if ($age == 0) {
                    //     // select all rows from the generateschedules
                    //     $stmt = $conn->query("SELECT * FROM generateschedules");

                    // } 
                    // else if ($chickenAge > 0 && $chickenAge <= 7) {
                    //     // select all rows from the generateschedules except the first 3 rows and will return 5 rows
                    //     $stmt = $conn->query("SELECT * FROM generateschedules LIMIT 5 OFFSET 3");
                    // } 
                    // else if ($chickenAge > 7 && $chickenAge <= 21) {
                    //     // select all rows from the generateschedules except the first 4 rows and will return 4 rows
                    //     $stmt = $conn->query("SELECT * FROM generateschedules LIMIT 4 OFFSET 4");
                    // } 
                    // else if ($chickenAge > 21 && $chickenAge <= 27) {
                    //     // select all rows from the generateschedules except the first 5 rows and will return 3 rows
                    //     $stmt = $conn->query("SELECT * FROM generateschedules LIMIT 3 OFFSET 5");
                    // } 
                    // else if ($chickenAge > 27 && $chickenAge <= 43) {
                    //     // select all rows from the generateschedules except the first 6 rows and will return 2 rows
                    //     $stmt = $conn->query("SELECT * FROM generateschedules LIMIT 2 OFFSET 6");
                    // } 
                    // else if ($chickenAge > 43 && $chickenAge <= 60) {
                    //     // select all rows from the generateschedules except the first 7 rows and will return 1 rows
                    //     $stmt = $conn->query("SELECT * FROM generateschedules LIMIT 1 OFFSET 7");
                    // } else {
                    //     $_SESSION['status'] = "Chicken Batch Added Successfully."; 
                    //     // Redirect the user to the success page
                    //     header("Location: chicken_production.php");
                    //     exit;
                    // }

                    // //if the age of the chicken is not 0, the age will be set to 0 in the first iteration
                    // $is_first_iteration = true;

                    // // Loop through the rows and insert them into the schedules table
                    // while ($row = $stmt->fetch()) {
                    //     //if the age is 0, the age will be set to zero always
                    //     if ($chickenAge == 0) {
                    //         $age = 0;
                    //     } else {
                    //         //refactored version If it is the first iteration and the chicken age is 7, 21, 27, 43, or 60, then set the age to 0.
                    //         // Otherwise, set the age to the absolute difference between the chicken age and the age in the current row of the generateschedules table.
                    //         // Set $is_first_iteration to false to prevent this code block from being executed on subsequent iterations.
                    //         if ($is_first_iteration && in_array($chickenAge, [7, 21, 27, 43, 60])) {
                    //             $age = 0;
                    //           } else {
                    //             $age = abs($chickenAge - $row['age']);
                    //           }
                    //           $is_first_iteration = false;

                    //         //  old code
                    //         // if ($is_first_iteration){
                    //         //     if($chickenAge == 7 || $chickenAge == 21 || $chickenAge == 27 || $chickenAge == 43 || $chickenAge == 60){
                    //         //         $age = 0; //if the age of the chicken is not zero, this will set the age to 0 for the first iteration so that the sched will be set on the same day.
                    //         //         $is_first_iteration = false;
                    //         //     }else{
                    //         //         $is_first_iteration = false;
                    //         //     }
                    //         // } else {
                    //         //     if($chickenAge > $row['age']){
                    //         //         $newAge = $chickenAge - $row['age'];
                    //         //     }else{
                    //         //         $newAge = $row['age'] - $chickenAge;
                    //         //     }                                
                    //         //     $age = $newAge;
                    //         // }
                    //     }
                        

                    //     $administrationSched = new DateTime('now'); // create todays date
                    //     $administrationSched->add(new DateInterval('P'.$age.'D')); // add the age to the date
                    //     $user_id = $user_ids[$counter % count($user_ids)]; 

                    //     // Prepare an insert statement
                    //     $sql = "INSERT INTO schedules (scheduleType, chickenBatch_ID, coopNumber, medicine_ID, medicineName, methodType, dosage, numberHeads, administrationSched, administeredBy, status, notes) VALUES (:scheduleType, :BatchID, :coopNumber, :medicine_ID, :medicineName, :method, :dosage, :inStock, :administrationSched, :user_id, :status, :newnote)";
                    //     $insert_stmt = $conn->prepare($sql);
                    
                    //     // Set parameters $param_numberHeads = $inStock;
                    //     $param_scheduleType = $scheduleType;
                    //     $param_BatchID = $BatchID['chickenBatch_ID'];
                    //     $param_coopNumber = $coopNumber;
                    //     $param_dosage = $dosage;
                    //     $param_numberHeads = $inStock;
                    //     $param_administrationSched = $administrationSched->format('Y-m-d');
                    //     $param_user_id = $user_id;
                    //     $param_status = $status;
                    //     $param_newnote = $newnote;

                    //     // Bind variables to the prepared statement as parameters
                    //     $insert_stmt->bindParam(":scheduleType", $param_scheduleType, PDO::PARAM_STR);
                    //     $insert_stmt->bindParam(":BatchID", $param_BatchID, PDO::PARAM_STR);
                    //     $insert_stmt->bindParam(":coopNumber", $param_coopNumber, PDO::PARAM_STR);
                    //     $insert_stmt->bindParam(":medicine_ID", $row['medicine_ID'], PDO::PARAM_STR);
                    //     $insert_stmt->bindParam(":medicineName", $row['medicineName'], PDO::PARAM_STR);
                    //     $insert_stmt->bindParam(":method", $row['method'], PDO::PARAM_STR);
                    //     $insert_stmt->bindParam(":dosage", $param_dosage, PDO::PARAM_STR);
                    //     $insert_stmt->bindParam(":inStock", $param_inStock, PDO::PARAM_STR);
                    //     $insert_stmt->bindParam(":administrationSched", $param_administrationSched, PDO::PARAM_STR); //
                    //     $insert_stmt->bindParam(":user_id", $param_user_id, PDO::PARAM_STR); //
                    //     $insert_stmt->bindParam(":status", $param_status, PDO::PARAM_STR);
                    //     $insert_stmt->bindParam(":newnote", $param_newnote, PDO::PARAM_STR);
                    
                    //     $counter++;
                    //     // Execute the prepared statement
                    //     $insert_stmt->execute();
                    // }

                    // Close the connection
                    // $conn = null;

                    if($sex == 'Male'){
                        // Prepare an update statement to update inStock
                        $sql = "UPDATE chickenproduction SET male = male + :quantity, inStock = inStock + :quantity WHERE coopNumber = '$coopNumber'";
                    
                        if($stmt = $conn->prepare($sql))
                        {
                            // Bind variables to the prepared statement as parameters
                            $stmt->bindParam(":quantity", $param_quantity, PDO::PARAM_STR);

                            // Set parameters
                            $param_quantity = $quantity;
                            // Attempt to execute the prepared statement
                            $stmt->execute();

                            // Close statement
                            unset($stmt);
                        }
                    }else{
                        // Prepare an update statement to update inStock
                        $sql = "UPDATE chickenproduction SET female = female + :quantity, inStock = inStock + :quantity WHERE coopNumber = '$coopNumber'";
                                        
                        if($stmt = $conn->prepare($sql))
                        {
                            // Bind variables to the prepared statement as parameters
                            $stmt->bindParam(":quantity", $param_quantity, PDO::PARAM_STR);

                            // Set parameters
                            $param_quantity = $quantity;
                            // Attempt to execute the prepared statement
                            $stmt->execute();

                            // Close statement
                            unset($stmt);
                        }
                    }
                    

                    $_SESSION['status'] = "Chicken Batch Added Successfully."; 
                    // Redirect the user to the success page
                    header("Location: chicken_production.php");
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