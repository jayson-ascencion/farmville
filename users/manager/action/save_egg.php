<?php
//database connection, located in the config directory
include('../../../config/database_connection.php');

try{

    //define variables
    $eggSize = $quantity = $collectionDate =  $collectionType = $note = "";

    //variables to store error message
    $eggSize_err = $quantity_err = $collectionDate_err = $collectionType_err = $note_err = "";
    
    //processing the data from the form submitted
    if(isset($_POST['submit'])){

        //collect data from the form
        $eggSize = $_POST['eggSize'];
        $quantity = $_POST['quantity'];
        $collectionDate = $_POST['collectionDate']; //date("Y-m-d");
        $collectionType = $_POST['collectionType'];
        $note = $_POST['note'];
    

        //validate medicine name if empty and allows only alphabets and white spaces
        if (empty(trim($eggSize))) {  
            $eggSize_err = "Please enter egg size.";
        }

        //validate starting quantity if empty
        if (!preg_match ("/^[0-9]*$/", $quantity) ){  
            $quantity_err = "Please enter a valid quantity."; 
        }

        //validate collection date if empty
        if (empty($collectionDate) ){  
            $collectionDate_err = "Please enter date acquired."; 
        }

        //validate collectionType
        if (empty($collectionType)){
            $collectionType_err = "Please select batch purpose";
        }

        if(empty($note)){
            $note = "no note.";
        }else if(strlen(trim($note)) > 100){
            $note_err = "Note exceeded 100 characters.";
        }


        if(empty($eggSize_err) && empty($quantity_err) && empty($collectionDate_err) && empty($collectionType_err) && empty($note_err)){

           // Prepare an insert statement
           $sql = "INSERT INTO eggproduction (eggSize, quantity, collectionDate, collectionType, note) VALUES (:eggSize, :quantity, :collectionDate, :collectionType, :note)";
         
           if($stmt = $conn->prepare($sql))
           {
               // Bind variables to the prepared statement as parameters
               $stmt->bindParam(":eggSize", $param_eggSize, PDO::PARAM_STR);
               $stmt->bindParam(":quantity", $param_quantity, PDO::PARAM_STR);
               $stmt->bindParam(":collectionDate", $param_collectionDate, PDO::PARAM_STR);
               $stmt->bindParam(":collectionType", $param_collectionType, PDO::PARAM_STR);
               $stmt->bindParam(":note", $param_note, PDO::PARAM_STR);

               // Set parameters
               $param_eggSize = $eggSize;
               $param_quantity = $quantity;
               $param_collectionDate = $collectionDate;
               $param_collectionType = $collectionType;
               $param_note = $note;
               // Attempt to execute the prepared statement
               if($stmt->execute())
               {
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