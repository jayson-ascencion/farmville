<?php
//database connection, located in the config directory
include('../../../config/database_connection.php');

try{

    //define variables
    $eggSize_ID = $eggSize_ID = $quantity =  $collectionType = $collectionDate = $note = "";

    //variables to store error message
    $eggSize_ID_err = $quantity_err = $collectionDate_err = $collectionType_err = $note_err = "";
    
    //processing the data from the form submitted
    if(isset($_POST['submit'])){

        //collect data from the form
        $eggSize_ID = $_POST['eggSize_ID'];
        $quantity = $_POST['quantity'];
        $collectionDate = $_POST['collectionDate']; //date("Y-m-d");
        $collectionType = $_POST['collectionType'];
        $note = $_POST['note'];
        $user_ID = $_SESSION["user_ID"];

        //validate medicine name if empty and allows only alphabets and white spaces
        if (empty(trim($eggSize_ID))) {  
            $eggSize_err = "Please select egg size.";
        }else{
            $sql = "SELECT eggSize FROM eggproduction WHERE eggSize_ID = $eggSize_ID";
            $stmt = $conn->query($sql);
            if($stmt){
                if($stmt->rowCount() > 0){
                    while($row = $stmt->fetch()){
                        $eggSize = $row['eggSize'];
                    }
                }
            }
        }

        //validate starting quantity if empty
        if (!preg_match ("/^[0-9]+$/", $quantity) ){  
            $quantity_err = "Please enter a valid quantity."; 
        }

        //validate collection date if empty
        if (empty($collectionDate) ){  
            $collectionDate_err = "Please enter collection date."; 
        }

        //validate collectionType
        if (empty($collectionType)){
            $collectionType_err = "Please select collection type";
        }

        if(empty($note)){
            $note = "no note.";
        }else if(strlen(trim($note)) > 100){
            $note_err = "Note exceeded 100 characters.";
        }


        if(empty($eggSize_ID_err) && empty($quantity_err) && empty($collectionDate_err) && empty($collectionType_err) && empty($note_err)){

           // Prepare an insert statement
           $sql = "INSERT INTO eggtransaction (eggSize_ID, user_ID, eggSize, quantity, dispositionType, transactionDate, note) VALUES (:eggSize_ID, :user_ID, :eggSize, :quantity, :collectionType, :collectionDate, :note)";
         
           if($stmt = $conn->prepare($sql))
           {
               // Bind variables to the prepared statement as parameters
               $stmt->bindParam(":eggSize_ID", $param_eggSize_ID, PDO::PARAM_STR);
               $stmt->bindParam(":user_ID", $param_user_ID, PDO::PARAM_STR);
               $stmt->bindParam(":eggSize", $param_eggSize, PDO::PARAM_STR);
               $stmt->bindParam(":quantity", $param_quantity, PDO::PARAM_STR);
               $stmt->bindParam(":collectionType", $param_collectionType, PDO::PARAM_STR);
               $stmt->bindParam(":collectionDate", $param_collectionDate, PDO::PARAM_STR);
               $stmt->bindParam(":note", $param_note, PDO::PARAM_STR);

               // Set parameters
               $param_eggSize_ID = $eggSize_ID;
               $param_user_ID = $user_ID;
               $param_eggSize = $eggSize;
               $param_quantity = $quantity;
               $param_collectionType = $collectionType;
               $param_collectionDate = $collectionDate;
               $param_note = $note;
               // Attempt to execute the prepared statement
               if($stmt->execute())
               {
                    // Prepare an update statement to update inStock
                    $sql = "UPDATE eggproduction SET inStock = inStock + :quantity WHERE eggSize_ID = '$eggSize_ID'";
                
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
                $_SESSION['status'] = "Egg Batch Added Successfully.";
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