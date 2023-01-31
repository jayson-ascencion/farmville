<?php
//database connection, located in the config directory
include('../../../config/database_connection.php');

try{

    //define variables
    $eggSize = $quantity = $collectionType = $collectionDate = $note = $success = "";

    //variables to store error message
    $eggSize_err = $quantity_err = $collectionType_err = $collectionDate_err = $note_err = "";
    
    //processing the data from the form submitted
    if(isset($_POST['submit'])){
        $id = $_REQUEST['id'];

        //collect data from the form
        $eggSize = $_POST['eggSize'];
        $quantity = $_POST['quantity'];
        $collectionType = $_POST['collectionType'];
        $collectionDate = $_POST['collectionDate'];
        $note = $_POST['note'];
    
        //validate egg size
        if (empty(trim($eggSize))) {  
            $eggSize_err = "Please egg size.";
        }
        
        //validate quantity
        if (!preg_match ("/^[0-9]*$/", $quantity)) {  
            $quantity_err = "Please enter a valid quantity."; 
        }
        else if (empty(trim($quantity))) {  
            $quantity_err = "Please enter quantity.";
        }else if($quantity<0){
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


        if(empty($eggSize_err) && empty($quantity_err) && empty($collectionType_err) && empty($collectionDate_err)){

           // Prepare an insert statement
           $sql = "UPDATE eggproduction SET eggSize=:eggSize, quantity=:quantity, collectionType=:collectionType, collectionDate=:collectionDate, note=:note WHERE eggBatch_ID = '$id'";
         
           if($stmt = $conn->prepare($sql))
           {
               // Bind variables to the prepared statement as parameters
               $stmt->bindParam(":eggSize", $param_eggSize, PDO::PARAM_STR);
               $stmt->bindParam(":quantity", $param_quantity, PDO::PARAM_STR);
               $stmt->bindParam(":collectionType", $param_collectionType, PDO::PARAM_STR);
               $stmt->bindParam(":collectionDate", $param_collectionDate, PDO::PARAM_STR);
               $stmt->bindParam(":note", $param_note, PDO::PARAM_STR);

               // Set parameters
               $param_eggSize = $eggSize;
               $param_quantity = $quantity;
               $param_collectionType = $collectionType;
               $param_collectionDate = $collectionDate;
               $param_note = $note;
               // Attempt to execute the prepared statement
               if($stmt->execute())
               {
                    // Prepare an update statement to update inStock
                    $sql = "UPDATE eggreduction SET eggSize=:eggSize WHERE eggBatch_ID = '$id'";
        
                    if($stmt = $conn->prepare($sql))
                    {
                        // Bind variables to the prepared statement as parameters
                        $stmt->bindParam(":eggSize", $param_eggSize, PDO::PARAM_STR);

                        // Set parameters
                        $param_eggSize = $eggSize;
                        // Attempt to execute the prepared statement
                        $stmt->execute();

                        // Close statement
                        unset($stmt);
                    }
                $_SESSION['status'] = "Egg Production Details Successfully Updated.";
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