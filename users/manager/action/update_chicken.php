<?php
//database connection, located in the config directory
include('../../../config/database_connection.php');

try{

    //define variables
    $coopNumber = $age = $batchName = $breedType = $batchPurpose = $inStock = $male = $female = $dateAcquired =  $acquisitionType = $note = $success = "";

    //variables to store error message
    $coopNumber_err = $age_err = $batchName_err = $breedType_err = $batchPurpose_err = $inStock_err = $male_err = $female_err = $dateAcquired_err = $acquisitionType_err = $note_err = "";
    
    //processing the data from the form submitted
    if(isset($_POST['submit'])){
        $id = $_REQUEST['id'];

        //collect data from the form
        $age = $_POST['age'];
        $coopNumber = $_POST['coopNumber'];
        $batchName = $_POST['batchName'];
        $breedType = $_POST['breedType'];
        $batchPurpose = $_POST['batchPurpose'];
        // $inStock = 
        $male = $_POST['male'];
        $female = $_POST['female'];
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
        if (!preg_match ("/^[0-9]+$/", $male) ){  
            $male_err = "Please enter a valid quantity."; 
        }else if(empty($male)){
            $male_err = "Please enter a valid quantity.";
        }

        //validate starting quantity if empty
        if (!preg_match ("/^[0-9]+$/", $female) ){  
            $female_err = "Please enter a valid quantity."; 
        }else if(empty($female)){
            $female_err = "Please enter a valid quantity.";
        }

        //validate starting quantity if empty
        if (!preg_match ("/^[0-9]+$/", $age) ){  
            $age_err = "Please enter a valid quantity."; 
        }else if(empty($age)){
            $age_err = "Please enter a valid quantity.";
        }

        //validate starting quantity if empty
        if (empty($dateAcquired) ){  
            $dateAcquired_err = "Please enter date acquired."; 
        }
        //validate acquisitionType
        if (empty($acquisitionType)){
            $acquisitionType_err = "Please select batch purpose";
        }


            $inStock = $male + $female;
            $user_ID = $_SESSION['user_ID'];
        if(empty($coopNumber_err) && empty($age_err) && empty($batchName_err) && empty($breedType_err) && empty($batchPurpose_err) && empty($male_err) && empty($female_err) && empty($dateAcquired_err) && empty($acquisitionType_err) && empty($note_err)){

           // Prepare an insert statement
            $sql = "UPDATE chickenproduction SET user_ID=:user_ID, age=:age, coopNumber=:coopNumber, batchName=:batchName, breedType=:breedType, batchPurpose=:batchPurpose, male=:male, female=:female, inStock=:inStock, dateAcquired=:dateAcquired, acquisitionType=:acquisitionType, note=:note WHERE chickenBatch_ID = '$id'";

           if($stmt = $conn->prepare($sql))
           {
            echo $sql;

               // Bind variables to the prepared statement as parameters
               $stmt->bindParam(":user_ID", $param_user_ID, PDO::PARAM_STR);
               $stmt->bindParam(":age", $param_age, PDO::PARAM_STR);
               $stmt->bindParam(":coopNumber", $param_coopNumber, PDO::PARAM_STR);
               $stmt->bindParam(":batchName", $param_batchName, PDO::PARAM_STR);
               $stmt->bindParam(":breedType", $param_breedType, PDO::PARAM_STR);
               $stmt->bindParam(":batchPurpose", $param_batchPurpose, PDO::PARAM_STR);
               $stmt->bindParam(":male", $param_male, PDO::PARAM_STR);
               $stmt->bindParam(":female", $param_female, PDO::PARAM_STR);
               $stmt->bindParam(":inStock", $param_inStock, PDO::PARAM_STR);
            //    $stmt->bindParam(":inStock", $param_inStock, PDO::PARAM_STR);
               $stmt->bindParam(":dateAcquired", $param_dateAcquired, PDO::PARAM_STR);
               $stmt->bindParam(":acquisitionType", $param_acquisitionType, PDO::PARAM_STR);
               $stmt->bindParam(":note", $param_note, PDO::PARAM_STR);

               // Set parameters
               $param_user_ID = $user_ID;
               $param_age = $age;
               $param_coopNumber = $coopNumber;
               $param_batchName = $batchName;
               $param_breedType = $breedType;
               $param_batchPurpose = $batchPurpose;
               $param_male = $male;
               $param_female = $female;
               $param_inStock = $inStock;
               $param_dateAcquired = $dateAcquired;
               $param_acquisitionType = $acquisitionType;
               $param_note = $note;

               // Attempt to execute the prepared statement
               if($stmt->execute())
               {
                    // Prepare an update statement to update inStock
                    $sql = "UPDATE chickentransaction SET coopNumber=:coopNumber, batchName=:batchName WHERE chickenBatch_ID = '$id'";
                        
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
                echo "Error updating record: " . $stmt->errorInfo();
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