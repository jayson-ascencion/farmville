<?php
//database connection, located in the config directory
include('../../../config/database_connection.php');

try{

    //define variables
    $coopNumber = $batchName = $breedType = $batchPurpose = $startingQuantity = $dateAcquired =  $acquisitionType = $note = $success = "";

    //variables to store error message
    $coopNumber_err = $batchName_err = $breedType_err = $batchPurpose_err = $startingQuantity_err = $dateAcquired_err = $acquisitionType_err = $note_err = "";
    
    //processing the data from the form submitted
    if(isset($_POST['submit'])){
        $id = $_REQUEST['id'];

        //collect data from the form
        $coopNumber = $_POST['coopNumber'];
        $batchName = $_POST['batchName'];
        $breedType = $_POST['breedType'];
        $batchPurpose = $_POST['batchPurpose'];
        $startingQuantity = $_POST['startingQuantity'];
        // $inStock = $_POST['inStock'];
        $dateAcquired = $_POST['dateAcquired'];
        $acquisitionType = $_POST['acquisitionType'];
        $note = $_POST['note'];
    
    
        //validate coop number and only accept numeric input
        if (!preg_match ("/^[0-9]+$/", trim($coopNumber)) ) {  
            $coopNumber_err = "Please enter a valid coop number.";
         }
         else if (empty(trim($coopNumber))) {  
             $coopNumber_err = "Please enter coop number.";
         }
         else if (!empty($coopNumber)) {

            $oldCoopNumber = "";

            // Prepare a select statement to get the old coop number
            $sql = "SELECT coopNumber FROM chickenproduction WHERE chickenBatch_ID = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    $row = $stmt->fetch();
                    $oldCoopNumber = $row['coopNumber'];
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Check if the coop number has changed
            if ($coopNumber == $oldCoopNumber) {
                // Do nothing, coop number remains unchanged
            } else {
                // Check if the new coop number already exists in the database
                // Prepare a select statement to check if coopNumber already exists
                $sql = "SELECT coopNumber FROM chickenproduction WHERE coopNumber = :coopNumber";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":coopNumber", $coopNumber, PDO::PARAM_STR);

                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    if ($stmt->rowCount() > 0) {
                        $coopNumber_err = "This coopNumber already exists.";
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
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
        if (!preg_match ("/^[0-9]+$/", $startingQuantity) ){  
            $startingQuantity_err = "Please enter a valid quantity."; 
        }

        //validate starting quantity if empty
        // if (!preg_match ("/^[0-9]+$/", $inStock) ){  
        //     $inStock_err = "Please enter a valid quantity."; 
        // }

        //validate starting quantity if empty
        if (empty($dateAcquired) ){  
            $dateAcquired_err = "Please enter date acquired."; 
        }
        //validate acquisitionType
        if (empty($acquisitionType)){
            $acquisitionType_err = "Please select batch purpose";
        }


        if(empty($coopNumber_err) && empty($batchName_err) && empty($breedType_err) && empty($batchPurpose_err) && empty($startingQuantity_err) && empty($dateAcquired_err) && empty($acquisitionType_err) && empty($note_err)){

           // Prepare an insert statement
           $sql = "UPDATE chickenproduction SET coopNumber=:coopNumber, batchName=:batchName, breedType=:breedType, batchPurpose=:batchPurpose, startingQuantity=:startingQuantity, dateAcquired=:dateAcquired, acquisitionType=:acquisitionType, note=:note WHERE chickenBatch_ID = '$id'";
         
           if($stmt = $conn->prepare($sql))
           {
               // Bind variables to the prepared statement as parameters
               $stmt->bindParam(":coopNumber", $param_coopNumber, PDO::PARAM_STR);
               $stmt->bindParam(":batchName", $param_batchName, PDO::PARAM_STR);
               $stmt->bindParam(":breedType", $param_breedType, PDO::PARAM_STR);
               $stmt->bindParam(":batchPurpose", $param_batchPurpose, PDO::PARAM_STR);
               $stmt->bindParam(":startingQuantity", $param_startingQuantity, PDO::PARAM_STR);
            //    $stmt->bindParam(":inStock", $param_inStock, PDO::PARAM_STR);
               $stmt->bindParam(":dateAcquired", $param_dateAcquired, PDO::PARAM_STR);
               $stmt->bindParam(":acquisitionType", $param_acquisitionType, PDO::PARAM_STR);
               $stmt->bindParam(":note", $param_note, PDO::PARAM_STR);

               // Set parameters
               $param_coopNumber = $coopNumber;
               $param_batchName = $batchName;
               $param_breedType = $breedType;
               $param_batchPurpose = $batchPurpose;
               $param_startingQuantity = $startingQuantity;
            //    $param_inStock = $inStock;
               $param_dateAcquired = $dateAcquired;
               $param_acquisitionType = $acquisitionType;
               $param_note = $note;
               // Attempt to execute the prepared statement
               if($stmt->execute())
               {
                    // Prepare an update statement to update inStock
                    $sql = "UPDATE chickenreduction SET coopNumber=:coopNumber, batchName=:batchName WHERE chickenBatch_ID = '$id'";
                        
                    if($stmt = $conn->prepare($sql))
                    {
                        // Bind variables to the prepared statement as parameters
                        $stmt->bindParam(":coopNumber", $param_coopNumber, PDO::PARAM_STR);
                        $stmt->bindParam(":batchName", $param_batchName, PDO::PARAM_STR);

                        // Set parameters
                        $param_coopNumber = $coopNumber;
                        $param_batchName = $batchName;
                        // Attempt to execute the prepared statement
                        $stmt->execute();

                        // Close statement
                        unset($stmt);
                    }
                $_SESSION['status'] = "Chicken Production Details Successfully Updated.";
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