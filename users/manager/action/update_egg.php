<?php
//database connection, located in the config directory
include('../../../config/database_connection.php');

    $id = $_REQUEST['id'];
    $sql = "SELECT eggSize_ID, quantity FROM eggtransaction WHERE collection_ID = $id";
    $stmt = $conn->query($sql);
    if($stmt){
        if($stmt->rowCount() > 0){
            while($row = $stmt->fetch()){
                $old_eggSize_ID = $row['eggSize_ID'];
                $old_quantity = $row['quantity'];
            }
        }
    }

    // $sql = "SELECT inStock FROM eggproduction WHERE eggSize_ID = $old_eggSize_ID";
    // $stmt = $conn->query($sql);
    // if($stmt){
    //     if($stmt->rowCount() > 0){
    //         while($row = $stmt->fetch()){
    //             $old_quantity = $row['inStock'];
    //         }
    //     }
    // }

try{

    //define variables
    $eggSize_ID = $quantity = $collectionType = $collectionDate = $note = $success = $newQuantity = "";

    //variables to store error message
    $eggSize_ID_err = $quantity_err = $collectionType_err = $collectionDate_err = $note_err = "";
    
    //processing the data from the form submitted
    if(isset($_POST['submit'])){
        $id = $_REQUEST['id'];

        //collect data from the form
        $new_eggSize_ID = $_POST['eggSize_ID'];
        $quantity = $_POST['quantity'];
        $collectionType = $_POST['collectionType'];
        $collectionDate = $_POST['collectionDate'];
        $note = $_POST['note'];
        $user_ID = $_SESSION["user_ID"];

        //validate egg size
        if (empty(trim($new_eggSize_ID))) {  
            $eggSize_ID_err = "Please select egg size.";
        }
        else{
            $sql = "SELECT eggSize FROM eggproduction WHERE eggSize_ID = $new_eggSize_ID";
            $stmt = $conn->query($sql);
            if($stmt){
                if($stmt->rowCount() > 0){
                    while($row = $stmt->fetch()){
                        $eggSize = $row['eggSize'];
                    }
                }
            }
        }
        
        //validate quantity
        if (!preg_match ("/^[0-9]*$/", $quantity)) {  
            $quantity_err = "Please enter a valid quantity."; 
        }
        else if($quantity<0){
            $quantity_err = "Please enter a valid quantity";
        }

        //validate medicine brand if empty and allows only alphabets and white spaces
        if (empty(trim($collectionType))) {  
            $collectionType_err = "Please enter collection type.";
        }

        //validate collectionDate
        if (empty($collectionDate)){
            $collectionDate_err = "Please select a date";
        }

        if(empty($note)){
            $note = "no note.";
        }else if(strlen(trim($note)) > 100){
            $note_err = "Note exceeded 100 characters.";
        }

        if(empty($eggSize_ID_err) && empty($quantity_err) && empty($collectionType_err) && empty($collectionDate_err) && empty($note_err)){

           // Prepare an insert statement
           $sql = "UPDATE eggtransaction SET eggSize_ID=:new_eggSize_ID, user_ID=:user_ID, eggSize=:eggSize, quantity=:quantity, dispositionType=:collectionType, transactionDate=:collectionDate, note=:note WHERE collection_ID = '$id'";
         
           if($stmt = $conn->prepare($sql))
           {
               // Bind variables to the prepared statement as parameters
               $stmt->bindParam(":new_eggSize_ID", $param_new_eggSize_ID, PDO::PARAM_STR);
               $stmt->bindParam(":user_ID", $param_user_ID, PDO::PARAM_STR);
               $stmt->bindParam(":eggSize", $param_eggSize, PDO::PARAM_STR);
               $stmt->bindParam(":quantity", $param_quantity, PDO::PARAM_STR);
               $stmt->bindParam(":collectionType", $param_collectionType, PDO::PARAM_STR);
               $stmt->bindParam(":collectionDate", $param_collectionDate, PDO::PARAM_STR);
               $stmt->bindParam(":note", $param_note, PDO::PARAM_STR);

               // Set parameters
               $param_new_eggSize_ID = $new_eggSize_ID;
               $param_user_ID = $user_ID;
               $param_eggSize  = $eggSize ;
               $param_quantity = $quantity;
               $param_collectionType = $collectionType;
               $param_collectionDate = $collectionDate;
               $param_note = $note;
               // Attempt to execute the prepared statement
               if($stmt->execute())
               {
                    // if($new_eggSize_ID != $old_eggSize_ID){
                    //     // Prepare an update statement to update inStock
                    //     $sql = "UPDATE eggreduction SET eggSize_ID=:eggSize_ID WHERE eggBatch_ID = '$id'";
            
                    //     if($stmt = $conn->prepare($sql))
                    //     {
                    //         // Bind variables to the prepared statement as parameters
                    //         $stmt->bindParam(":eggSize_ID", $param_eggSize, PDO::PARAM_STR);

                    //         // Set parameters
                    //         $param_eggSize = $eggSize_ID;
                    //         // Attempt to execute the prepared statement
                    //         $stmt->execute();

                    //         // Close statement
                    //         unset($stmt);
                    //     }
                    // }
                    if($new_eggSize_ID == $old_eggSize_ID){
                        if($quantity > $old_quantity){
                            $diff = $quantity - $old_quantity;
                            $stmt = $conn->prepare('UPDATE eggproduction SET inStock = inStock + :diff  WHERE eggSize_ID = :old_eggSize_ID');
                            $stmt->bindValue(':diff', $diff, PDO::PARAM_INT);
                            $stmt->bindValue(':old_eggSize_ID', $old_eggSize_ID, PDO::PARAM_STR);
                            $stmt->execute();
                        }else{
                            $diff = $old_quantity - $quantity;
                            $stmt = $conn->prepare('UPDATE eggproduction SET inStock = inStock - :diff  WHERE eggSize_ID = :old_eggSize_ID');
                            $stmt->bindValue(':diff', $diff, PDO::PARAM_INT);
                            $stmt->bindValue(':old_eggSize_ID', $old_eggSize_ID, PDO::PARAM_STR);
                            $stmt->execute();
                        }
                    }else if ($new_eggSize_ID != $old_eggSize_ID) {

                        // if($quantity > $old_quantity){
                        //     // Deduct quantity from old ID
                        //     $stmt = $conn->prepare('UPDATE eggproduction SET inStock = :quantity - inStock  WHERE eggSize_ID = :old_eggSize_ID');
                        //     $stmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);
                        //     $stmt->bindValue(':old_eggSize_ID', $old_eggSize_ID, PDO::PARAM_STR);
                        //     $stmt->execute();
                        
                        //     // Add quantity to new ID
                        //     $stmt = $conn->prepare('UPDATE eggproduction SET inStock = inStock + :quantity WHERE eggSize_ID = :new_eggSize_ID');
                        //     $stmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);
                        //     $stmt->bindValue(':new_eggSize_ID', $new_eggSize_ID, PDO::PARAM_STR);
                        //     $stmt->execute();
                        // }else{
                            // Deduct quantity from old ID
                            $stmt = $conn->prepare('UPDATE eggproduction SET inStock = inStock - :old_quantity  WHERE eggSize_ID = :old_eggSize_ID');
                            $stmt->bindValue(':old_quantity', $old_quantity, PDO::PARAM_INT);
                            $stmt->bindValue(':old_eggSize_ID', $old_eggSize_ID, PDO::PARAM_STR);
                            $stmt->execute();
                        
                            // Add quantity to new ID
                            $stmt = $conn->prepare('UPDATE eggproduction SET inStock = inStock + :quantity WHERE eggSize_ID = :new_eggSize_ID');
                            $stmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);
                            $stmt->bindValue(':new_eggSize_ID', $new_eggSize_ID, PDO::PARAM_STR);
                            $stmt->execute();
                        // }
                        
                    }
                      
                    // // Prepare an update statement to update inStock
                    // $sql = "UPDATE eggreduction SET eggSize_ID=:eggSize_ID WHERE eggBatch_ID = '$id'";
        
                    // if($stmt = $conn->prepare($sql))
                    // {
                    //     // Bind variables to the prepared statement as parameters
                    //     $stmt->bindParam(":eggSize_ID", $param_eggSize, PDO::PARAM_STR);

                    //     // Set parameters
                    //     $param_eggSize = $eggSize_ID;
                    //     // Attempt to execute the prepared statement
                    //     $stmt->execute();

                    //     // Close statement
                    //     unset($stmt);
                    // }
                $_SESSION['status'] = "Egg Production Details Successfully Updated." . $eggSize_ID
                ;
                header("Location: egg_production.php");
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