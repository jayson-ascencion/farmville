<?php
//database connection, located in the config directory
include('../../../config/database_connection.php');

try{

    //define variables
    $age = $coopNumber = $batchName = $breedType = $batchPurpose = $startingQuantity = $inStock = $dateAcquired =  $acquisitionType = $note = "";

    //variables to store error message
    $age_err = $coopNumber_err = $batchName_err = $breedType_err = $batchPurpose_err = $startingQuantity_err = $inStock_err = $dateAcquired_err = $acquisitionType_err = $note_err = "";
    
    //processing the data from the form submitted
    if(isset($_POST['submit'])){

        //collect data from the form
        $age = $_POST['age'];
        $coopNumber = $_POST['coopNumber'];
        $batchName = $_POST['batchName'];
        $breedType = $_POST['breedType'];
        $batchPurpose = $_POST['batchPurpose'];
        $startingQuantity = $_POST['startingQuantity'];
        $dateAcquired = $_POST['dateAcquired'];
        $acquisitionType = $_POST['acquisitionType'];
        $note = $_POST['note'];
    
        //validate age if empty
        if (!preg_match ("/^[0-9]*$|^0$/", $age) ){  
            $age_err = "Please enter a valid age."; 
        }
        else if(empty($age)){
            $age_err = "Please enter age";
        }

        //validate coop number and only accept numeric input
        if (!preg_match ("/^[0-9]*$/", trim($coopNumber)) ) {  
           $coopNumber_err = "Only alphabets and whitespace are allowed.";
        }
        else if (empty(trim($coopNumber))) {  
            $coopNumber_err = "Please enter coop number.";
        }
        
        //validate medicine name if empty and allows only alphabets and white spaces
        if (empty(trim($batchName))) {  
            $batchName_err = "Please enter batch name.";
        }

        //validate breed type if empty and allows only alphabets and white spaces
        if (empty(trim($breedType))) {  
            $breedType_err = "Please enter breed type.";
        }

        //validate batchPurpose
        if (empty($batchPurpose)){
            $batchPurpose_err = "Please select batch purpose";
        }

        //validate starting quantity if empty
        if (!preg_match ("/^[0-9]*$/", $startingQuantity) ){  
            $startingQuantity_err = "Please enter a valid quantity."; 
        }
        else if(empty($startingQuantity)){
            $startingQuantity_err = "Please enter age";
        }
        //validate starting quantity if empty
        if (empty($dateAcquired) ){  
            $dateAcquired_err = "Please enter date acquired."; 
        }
        //validate acquisitionType
        if (empty($acquisitionType)){
            $acquisitionType_err = "Please select acquisition type";
        }

        //validate note
        if(empty($note)){
            $note = "no note.";
        }else if(strlen(trim($note)) > 100){
            $note_err = "Note exceeded the 100 characters limit.";
        }


        if(empty($coopNumber_err) && empty($batchName_err) && empty($breedType_err) && empty($batchPurpose_err) && empty($startingQuantity_err) && empty($inStock_err) && empty($dateAcquired_err) && empty($acquisitionType_err) && empty($note_err)){

           // Prepare an insert statement
           $sql = "INSERT INTO chickenproduction (age, coopNumber, batchName, breedType, batchPurpose, startingQuantity, inStock, dateAcquired, acquisitionType, note) VALUES (:age, :coopNumber, :batchName, :breedType, :batchPurpose, :startingQuantity, :startingQuantity, :dateAcquired, :acquisitionType, :note)";
         
           if($stmt = $conn->prepare($sql))
           {
               // Bind variables to the prepared statement as parameters
               $stmt->bindParam(":age", $param_age, PDO::PARAM_STR);
               $stmt->bindParam(":coopNumber", $param_coopNumber, PDO::PARAM_STR);
               $stmt->bindParam(":batchName", $param_batchName, PDO::PARAM_STR);
               $stmt->bindParam(":breedType", $param_breedType, PDO::PARAM_STR);
               $stmt->bindParam(":batchPurpose", $param_batchPurpose, PDO::PARAM_STR);
               $stmt->bindParam(":startingQuantity", $param_startingQuantity, PDO::PARAM_STR);
               $stmt->bindParam(":inStock", $param_inStock, PDO::PARAM_STR);
               $stmt->bindParam(":dateAcquired", $param_dateAcquired, PDO::PARAM_STR);
               $stmt->bindParam(":acquisitionType", $param_acquisitionType, PDO::PARAM_STR);
               $stmt->bindParam(":note", $param_note, PDO::PARAM_STR);

               // Set parameters
               $param_age = $age;
               $param_coopNumber = $coopNumber;
               $param_batchName = $batchName;
               $param_breedType = $breedType;
               $param_batchPurpose = $batchPurpose;
               $param_startingQuantity = $startingQuantity;
               $param_inStock = $startingQuantity;
               $param_dateAcquired = $dateAcquired;
               $param_acquisitionType = $acquisitionType;
               $param_note = $note;
               // Attempt to execute the prepared statement
               if($stmt->execute())
               {
                    // // Retrieve the age for a particular user
                    // $getBatchId = "SELECT chickenBatch_ID FROM chickenproduction WHERE coopNumber = $coopNumber";
                    // $stmt = $conn->prepare($getBatchId);
                    // $stmt->execute();
                    // $BatchID = $stmt->fetch(PDO::FETCH_ASSOC);

                    // $scheduleType = 'vaccination';
                    // // Initialize the $stmt variable
                    // $stmt = null;

                    // // Select rows from the generateschedules table based on the age
                    // if ($age == 0) {
                    //     $stmt = $conn->query("SELECT * FROM generateschedules");
                    // } 
                    // else if ($age == 7) {
                    //     $stmt = $conn->query("SELECT * FROM generateschedules LIMIT 4 OFFSET 3");
                    // } 
                    // else if ($age == 21) {
                    //     $stmt = $conn->query("SELECT * FROM generateschedules LIMIT 5 OFFSET 4");
                    // } 
                    // else if ($age == 27) {
                    //     $stmt = $conn->query("SELECT * FROM generateschedules LIMIT 6 OFFSET 5");
                    // } 
                    // else if ($age == 43) {
                    //     $stmt = $conn->query("SELECT * FROM generateschedules LIMIT 7 OFFSET 6");
                    // } 
                    // else if ($age == 60) {
                    //     $stmt = $conn->query("SELECT * FROM generateschedules LIMIT 8 OFFSET 7");
                    // } else {
                    // // Redirect the user to the success page
                    // header("Location: chicken_production.php");
                    // exit;
                    // }
                    
                    // // Loop through the rows and insert them into the chickenproduction table
                    // while ($row = $stmt->fetch()) {
                    //     // Prepare an insert statement
                    //     $sql = "INSERT INTO generateschedules (age, medicine_ID, medicineName, method) VALUES (:age, :medicine_ID, :medicineName, :method)";
                    //     $insert_stmt = $conn->prepare($sql);
                    
                    //     // Bind variables to the prepared statement as parameters
                    //     $insert_stmt->bindParam(":age", $row['age'], PDO::PARAM_STR);
                    //     $insert_stmt->bindParam(":medicine_ID", $row['medicine_ID'], PDO::PARAM_STR);
                    //     $insert_stmt->bindParam(":medicineName", $row['medicineName'], PDO::PARAM_STR);
                    //     $insert_stmt->bindParam(":method", $row['method'], PDO::PARAM_STR);
                    
                    //     // Execute the prepared statement
                    //     $insert_stmt->execute();
                    // }

                    // // Close the connection
                    // $conn = null;

                    // Redirect the user to the success page
                    header("Location: chicken_production.php");
                    exit;
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