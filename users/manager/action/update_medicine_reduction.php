<?php
//database connection, located in the config directory
include('../../../config/database_connection.php');
    $id = $_REQUEST['id'];

    //this will hold the quantity before update
    $oldQuantity = "";

    //statement to get the old quantity
    $sql = "SELECT quantity FROM medicinetransaction WHERE transaction_ID = '$id'";
    $stmt = $conn->query($sql);

    if($stmt){
        if($stmt->rowCount() > 0){
            while($row = $stmt->fetch()){
                $oldQuantity = $row['quantity'];
            }
            // Free result set
            unset($result);
        } else{
            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
        }
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }

    $user_ID = $_SESSION["user_ID"];
try{

    //define variables
    $medicine_ID = $updateQuantity = $reductionType =  $dateReduced = "";
    
    //this will hold the quantity in stock
    $inStock = "";

    //this will will the difference between the update quantity and old quantity
    $diff = "";

    //this will hold the new quantity for instock after adding/subtracting update and old quantity
    $newQuantity = "";

    //variables to store error message
    $medicine_ID_err = $updateQuantity_err = $reductionType_err = $dateReduced_err = "";
    
    //processing the data from the form submitted
    if(isset($_POST['submit'])){
        $id = $_REQUEST['id'];

        //collect data from the form
        $medicine_ID = $_POST['medicine_ID'];
        $updateQuantity = $_POST['quantity'];
        $reductionType =  $_POST['reductionType'];
        $dateReduced = $_POST['dateReduced'];
    
    
        //validate medicine id if empty
        if (empty(trim($medicine_ID))) {  
            $medicine_ID_err = "Please enter medicine ID.";
        }
        // else{
            // $sql = "SELECT * FROM medicines WHERE medicine_ID = $medicine_ID";
            // $stmt = $conn->query($sql);
            // if($stmt){
            //     if($stmt->rowCount() > 0){
            //         while($row = $stmt->fetch()){
            //             $medicineName = $row['medicineName'];
            //         }
            //     }
            // }
        // }
        
        //statement to get the in stock in the medicines using medicine id
        $sql = "SELECT medicineName, inStock FROM medicines WHERE medicine_ID = '$medicine_ID'";
        $stmt = $conn->query($sql);

        if($stmt){
            if($stmt->rowCount() > 0){
                while($row = $stmt->fetch()){
                $inStock = $row['inStock'];
                // $medicineName = $row['medicineName'];
                }
                // Free result set
                unset($result);
            } else{
                echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
            }
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }

        //validate updateQuantity if empty and only allows number
        if (!preg_match ("/^[0-9]*$/", $updateQuantity) ){  
            $updateQuantity_err = "Please enter a valid quantity."; 
        }else if(empty($updateQuantity)){
            $updateQuantity_err = "Please enter a quantity";
        }else if(!empty($updateQuantity)){
            
            if($updateQuantity == $oldQuantity){
                $newQuantity = $inStock;
            }
            else if($updateQuantity > $oldQuantity){
                $diff = $updateQuantity - $oldQuantity;

                if($diff > $inStock){
                    $updateQuantity_err = "Quantity is greater than the stock available. Stock available is only " . $inStock . ".";
                }
                else{
                    $newQuantity = $inStock - $diff;
                }
            }
            else if($updateQuantity < $oldQuantity){
                $diff = $oldQuantity - $updateQuantity;

                $newQuantity = $inStock + $diff;

            }
        }else if($updateQuantity < 1){
            $updateQuantity_err = "Please enter a valid quantity.";
        }

        //validate reduction type if empty
        if (empty($reductionType)){
            $reductionType_err = "Please select a reduction type";
        }

        //validate expiration date if empty
        if (empty($dateReduced)){
            $dateReduced_err = "Please select a date";
        }

        if(empty($medicine_ID_err) && empty($medicineName_err) && empty($updateQuantity_err) && empty($reductionType_err) && empty($dateReduced_err)){
            $sql = "SELECT * FROM medicines WHERE medicine_ID = $medicine_ID";
            $stmt = $conn->query($sql);
            if($stmt){
                if($stmt->rowCount() > 0){
                    while($row = $stmt->fetch()){
                        $medicineName = $row['medicineName'];
                    }
                }
            }
            unset($stmt);
            
           // Prepare an insert statement
           $sql = "UPDATE medicinetransaction SET medicine_ID=:medicine_ID, medicineName=:medicineName, quantity=:updateQuantity, reductionType=:reductionType, transactionDate=:dateReduced, user_ID=:user_ID WHERE transaction_ID = '$id'";
         
           if($stmt = $conn->prepare($sql))
           {
               // Bind variables to the prepared statement as parameters
               $stmt->bindParam(":medicine_ID", $param_medicine_ID, PDO::PARAM_STR);
               $stmt->bindParam(":medicineName", $param_medicineName, PDO::PARAM_STR);
               $stmt->bindParam(":updateQuantity", $param_updateQuantity, PDO::PARAM_STR);
               $stmt->bindParam(":reductionType", $param_reductionType, PDO::PARAM_STR);
               $stmt->bindParam(":dateReduced", $param_dateReduced, PDO::PARAM_STR);
               $stmt->bindParam(":user_ID", $param_user_ID, PDO::PARAM_STR);

               // Set parameters
               $param_medicine_ID = $medicine_ID;
               $param_medicineName = $medicineName;
               $param_updateQuantity = $updateQuantity;
               $param_reductionType = $reductionType;
               $param_dateReduced = $dateReduced;
               $param_user_ID = $user_ID;
               // Attempt to execute the prepared statement
               if($stmt->execute())
               {
                    // Prepare an update statement to update inStock
                    $sql = "UPDATE medicines SET inStock=:newQuantity WHERE medicine_ID = '$medicine_ID'";
    
                    if($stmt = $conn->prepare($sql))
                    {
                        // Bind variables to the prepared statement as parameters
                        $stmt->bindParam(":newQuantity", $param_newQuantity, PDO::PARAM_STR);

                        // Set parameters
                        $param_newQuantity = $newQuantity;
                        // Attempt to execute the prepared statement
                        $stmt->execute();

                        // Close statement
                        unset($stmt);
                    }
                $_SESSION['status'] = "Medicine Reduction Details Successfully Updated." . $medicine_ID;
                header("Location: medicine_reduction.php");
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