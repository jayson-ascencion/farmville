<?php
//database connection, located in the config directory
include('../../../config/database_connection.php');
$id = $_REQUEST['id'];
$sql = "SELECT sex, quantity, coopNumber FROM chickentransaction WHERE transaction_ID = $id";
$stmt = $conn->query($sql);
if($stmt){
    if($stmt->rowCount() > 0){
        while($row = $stmt->fetch()){
            $old_sex = $row['sex'];
            $old_quantity = $row['quantity'];
            $old_coopNumber = $row['coopNumber'];
        }
    }
}

try{

    //define variables
    $age = $coopNumber = $chickenBatch_ID = $batchName = $breedType = $sex = $quantity = $batchPurpose = $inStock = $dateAcquired =  $acquisitionType = $note = "";

    //variables to store error message
    $age_err = $coopNumber_err = $batchName_err = $breedType_err = $sex_err = $quantity_err = $batchPurpose_err = $startingQuantity_err = $inStock_err = $dateAcquired_err = $acquisitionType_err = $note_err = "";
    
    //processing the data from the form submitted
    if(isset($_POST['submit'])){
        $id = $_POST['id'];
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
           $sql = "UPDATE chickentransaction SET coopNumber=:coopNumber, batchName=:batchName, sex=:sex, quantity=:quantity, transactionDate=:dateAcquired, note=:note, user_ID=:user_ID, chickenBatch_ID=:chickenBatch_ID WHERE transaction_ID = '$id'";
         
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
            //    $stmt->bindParam(":dispositionType", $param_dispositionType, PDO::PARAM_STR);
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
                    // // Prepare an update statement to update inStock
                    // $sql = "UPDATE chickenproduction SET male = female + :quantity, inStock = inStock + :quantity WHERE coopNumber = '$coopNumber'";
                
                    // if($stmt = $conn->prepare($sql))
                    // {
                    //     // Bind variables to the prepared statement as parameters
                    //     $stmt->bindParam(":quantity", $param_quantity, PDO::PARAM_STR);

                    //     // Set parameters
                    //     $param_quantity = $quantity;
                    //     // Attempt to execute the prepared statement
                    //     $stmt->execute();

                    //     // Close statement
                    //     unset($stmt);
                    // }

                    // if($old_sex != $sex){

                    //     //deduct the sex quantity in the chickenproduction and deduct the instock

                    //     //add sex quantity to the sex and instock

                    // }
                    if($coopNumber == $old_coopNumber){
                        if($sex == $old_sex){
                            // if($quantity > $old_quantity){
                            //     $diff = $quantity - $old_quantity;
                            //     $stmt = $conn->prepare('UPDATE chickenproduction SET inStock = inStock + :diff  WHERE coopNumber = :coopNumber');
                            //     $stmt->bindValue(':diff', $diff, PDO::PARAM_INT);
                            //     $stmt->bindValue(':coopNumber', $coopNumber, PDO::PARAM_STR);
                            //     $stmt->execute();
                            // }else{
                            //     $diff = $old_quantity - $quantity;
                            //     $stmt = $conn->prepare('UPDATE chickenproduction SET inStock = inStock - :diff  WHERE coopNumber = :coopNumber');
                            //     $stmt->bindValue(':diff', $diff, PDO::PARAM_INT);
                            //     $stmt->bindValue(':coopNumber', $coopNumber, PDO::PARAM_STR);
                            //     $stmt->execute();
                            // }

                            if($sex == 'Male'){
                                $stmt = $conn->prepare('UPDATE chickenproduction SET female = female - :old_quantity  WHERE coopNumber = :coopNumber');
                                $stmt->bindValue(':old_quantity', $old_quantity, PDO::PARAM_INT);
                                $stmt->bindValue(':coopNumber', $coopNumber, PDO::PARAM_STR);
                                $stmt->execute();
                            
                                // Add quantity to new ID
                                $stmt = $conn->prepare('UPDATE chickenproduction SET male = male + :quantity WHERE coopNumber = :coopNumber');
                                $stmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);
                                $stmt->bindValue(':coopNumber', $coopNumber, PDO::PARAM_STR);
                                $stmt->execute();
                            }else{
                                $stmt = $conn->prepare('UPDATE chickenproduction SET male = female - :old_quantity  WHERE coopNumber = :coopNumber');
                                $stmt->bindValue(':old_quantity', $old_quantity, PDO::PARAM_INT);
                                $stmt->bindValue(':coopNumber', $coopNumber, PDO::PARAM_STR);
                                $stmt->execute();
                            
                                // Add quantity to new ID
                                $stmt = $conn->prepare('UPDATE chickenproduction SET female = female + :quantity WHERE coopNumber = :coopNumber');
                                $stmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);
                                $stmt->bindValue(':coopNumber', $coopNumber, PDO::PARAM_STR);
                                $stmt->execute();
                            }

                        }else if ($sex != $old_sex) {
                            if($sex == 'Male'){
                                $stmt = $conn->prepare('UPDATE chickenproduction SET female = female - :old_quantity  WHERE coopNumber = :coopNumber');
                                $stmt->bindValue(':old_quantity', $old_quantity, PDO::PARAM_INT);
                                $stmt->bindValue(':coopNumber', $coopNumber, PDO::PARAM_STR);
                                $stmt->execute();
                            
                                // Add quantity to new ID
                                $stmt = $conn->prepare('UPDATE chickenproduction SET male = male + :quantity WHERE coopNumber = :coopNumber');
                                $stmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);
                                $stmt->bindValue(':coopNumber', $coopNumber, PDO::PARAM_STR);
                                $stmt->execute();
                            }else{
                                $stmt = $conn->prepare('UPDATE chickenproduction SET male = male - :old_quantity  WHERE coopNumber = :coopNumber');
                                $stmt->bindValue(':old_quantity', $old_quantity, PDO::PARAM_INT);
                                $stmt->bindValue(':coopNumber', $coopNumber, PDO::PARAM_STR);
                                $stmt->execute();
                            
                                // Add quantity to new ID
                                $stmt = $conn->prepare('UPDATE chickenproduction SET female = female + :quantity WHERE coopNumber = :coopNumber');
                                $stmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);
                                $stmt->bindValue(':coopNumber', $coopNumber, PDO::PARAM_STR);
                                $stmt->execute();
                            }
                            
                        }
                    }else if ($coopNumber != $old_coopNumber) {
                        $stmt = $conn->prepare('UPDATE chickenproduction SET inStock = inStock - :old_quantity  WHERE coopNumber = :old_coopNumber');
                        $stmt->bindValue(':old_quantity', $old_quantity, PDO::PARAM_INT);
                        $stmt->bindValue(':old_coopNumber', $old_coopNumber, PDO::PARAM_STR);
                        $stmt->execute();
                    
                        // Add quantity to new ID
                        $stmt = $conn->prepare('UPDATE chickenproduction SET inStock = inStock + :quantity WHERE coopNumber = :coopNumber');
                        $stmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);
                        $stmt->bindValue(':coopNumber', $coopNumber, PDO::PARAM_STR);
                        $stmt->execute();

                        if($sex == $old_sex){
                            if($quantity > $old_quantity){
                                $diff = $quantity - $old_quantity;
                                $stmt = $conn->prepare('UPDATE chickenproduction SET inStock = inStock + :diff  WHERE coopNumber = :coopNumber');
                                $stmt->bindValue(':diff', $diff, PDO::PARAM_INT);
                                $stmt->bindValue(':coopNumber', $coopNumber, PDO::PARAM_STR);
                                $stmt->execute();
                            }else{
                                $diff = $old_quantity - $quantity;
                                $stmt = $conn->prepare('UPDATE chickenproduction SET inStock = inStock - :diff  WHERE coopNumber = :coopNumber');
                                $stmt->bindValue(':diff', $diff, PDO::PARAM_INT);
                                $stmt->bindValue(':coopNumber', $coopNumber, PDO::PARAM_STR);
                                $stmt->execute();
                            }

                            if($sex == 'Male'){
                                $stmt = $conn->prepare('UPDATE chickenproduction SET male = male - :old_quantity  WHERE coopNumber = :old_coopNumber');
                                $stmt->bindValue(':old_quantity', $old_quantity, PDO::PARAM_INT);
                                $stmt->bindValue(':old_coopNumber', $old_coopNumber, PDO::PARAM_STR);
                                $stmt->execute();
                            
                                // Add quantity to new ID
                                $stmt = $conn->prepare('UPDATE chickenproduction SET male = male + :quantity WHERE coopNumber = :coopNumber');
                                $stmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);
                                $stmt->bindValue(':coopNumber', $coopNumber, PDO::PARAM_STR);
                                $stmt->execute();
                            }else{
                                $stmt = $conn->prepare('UPDATE chickenproduction SET female = female - :old_quantity  WHERE coopNumber = :old_coopNumber');
                                $stmt->bindValue(':old_quantity', $old_quantity, PDO::PARAM_INT);
                                $stmt->bindValue(':old_coopNumber', $old_coopNumber, PDO::PARAM_STR);
                                $stmt->execute();
                            
                                // Add quantity to new ID
                                $stmt = $conn->prepare('UPDATE chickenproduction SET female = female + :quantity WHERE coopNumber = :coopNumber');
                                $stmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);
                                $stmt->bindValue(':coopNumber', $coopNumber, PDO::PARAM_STR);
                                $stmt->execute();
                            }

                        }else if ($sex != $old_sex) {
                            if($sex == 'Male'){
                                $stmt = $conn->prepare('UPDATE chickenproduction SET female = female - :old_quantity  WHERE coopNumber = :old_coopNumber');
                                $stmt->bindValue(':old_quantity', $old_quantity, PDO::PARAM_INT);
                                $stmt->bindValue(':old_coopNumber', $old_coopNumber, PDO::PARAM_STR);
                                $stmt->execute();
                            
                                // Add quantity to new ID
                                $stmt = $conn->prepare('UPDATE chickenproduction SET male = male + :quantity WHERE coopNumber = :coopNumber');
                                $stmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);
                                $stmt->bindValue(':coopNumber', $coopNumber, PDO::PARAM_STR);
                                $stmt->execute();
                            }else{
                                $stmt = $conn->prepare('UPDATE chickenproduction SET male = female - :old_quantity  WHERE coopNumber = :old_coopNumber');
                                $stmt->bindValue(':old_quantity', $old_quantity, PDO::PARAM_INT);
                                $stmt->bindValue(':old_coopNumber', $old_coopNumber, PDO::PARAM_STR);
                                $stmt->execute();
                            
                                // Add quantity to new ID
                                $stmt = $conn->prepare('UPDATE chickenproduction SET female = female + :quantity WHERE coopNumber = :coopNumber');
                                $stmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);
                                $stmt->bindValue(':coopNumber', $coopNumber, PDO::PARAM_STR);
                                $stmt->execute();
                            }
                            
                        }
                        
                        
                    }

                    // if($sex == $old_sex){
                    //     if($quantity > $old_quantity){
                    //         $diff = $quantity - $old_quantity;
                    //         $stmt = $conn->prepare('UPDATE chickenproduction SET inStock = inStock + :diff  WHERE coopNumber = :coopNumber');
                    //         $stmt->bindValue(':diff', $diff, PDO::PARAM_INT);
                    //         $stmt->bindValue(':coopNumber', $coopNumber, PDO::PARAM_STR);
                    //         $stmt->execute();
                    //     }else{
                    //         $diff = $old_quantity - $quantity;
                    //         $stmt = $conn->prepare('UPDATE chickenproduction SET inStock = inStock - :diff  WHERE coopNumber = :coopNumber');
                    //         $stmt->bindValue(':diff', $diff, PDO::PARAM_INT);
                    //         $stmt->bindValue(':coopNumber', $coopNumber, PDO::PARAM_STR);
                    //         $stmt->execute();
                    //     }
                    // }else if ($sex != $old_sex) {
                    //     if($sex == 'Male'){
                    //         $stmt = $conn->prepare('UPDATE chickenproduction SET female = female - :old_quantity  WHERE coopNumber = :coopNumber');
                    //         $stmt->bindValue(':old_quantity', $old_quantity, PDO::PARAM_INT);
                    //         $stmt->bindValue(':coopNumber', $coopNumber, PDO::PARAM_STR);
                    //         $stmt->execute();
                        
                    //         // Add quantity to new ID
                    //         $stmt = $conn->prepare('UPDATE chickenproduction SET male = male + :quantity WHERE coopNumber = :coopNumber');
                    //         $stmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);
                    //         $stmt->bindValue(':coopNumber', $coopNumber, PDO::PARAM_STR);
                    //         $stmt->execute();
                    //     }else{
                    //         $stmt = $conn->prepare('UPDATE chickenproduction SET male = female - :old_quantity  WHERE coopNumber = :coopNumber');
                    //         $stmt->bindValue(':old_quantity', $old_quantity, PDO::PARAM_INT);
                    //         $stmt->bindValue(':coopNumber', $coopNumber, PDO::PARAM_STR);
                    //         $stmt->execute();
                        
                    //         // Add quantity to new ID
                    //         $stmt = $conn->prepare('UPDATE chickenproduction SET female = female + :quantity WHERE coopNumber = :coopNumber');
                    //         $stmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);
                    //         $stmt->bindValue(':coopNumber', $coopNumber, PDO::PARAM_STR);
                    //         $stmt->execute();
                    //     }
                        
                    // }


                    $_SESSION['status'] = "Chicken Batch Added Successfully." . $coopNumber . $old_coopNumber; 
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