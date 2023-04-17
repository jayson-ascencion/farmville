<?php
//database connection, located in the config directory
include('../../../config/database_connection.php');

try{

    //define variables
    $eggBatch_ID = $eggSize = $quantity = $reductionType = $dateReduced = $success = $newQuantity =  $productionQuantity = "";

    //variables to store error message
    $eggBatch_ID_err = $eggSize_err = $quantity_err = $reductionType_err = $dateReduced_err = "";
    
    //processing the data from the form submitted
    if(isset($_POST['submit'])){

        //collect data from the form
        $eggBatch_ID = $_POST['eggBatch_ID'];
        $quantity = $_POST['quantity'];
        $reductionType = $_POST['reductionType'];
        $dateReduced = $_POST['dateReduced'];
        
        //validate egg batch ID
        if(empty($eggBatch_ID)){
            $eggBatch_ID_err = "Please select egg batch ID";
        }
        
        //validate quantity if empty
        if (!preg_match ("/^[0-9]+$/", $quantity) ){  
            $quantity_err = "Please enter a valid quantity."; 
        }
        else if($quantity<1){
            $quantity_err = "Please enter a valid quantity."; 
        }
        else if (!empty($quantity)){
            $sql = "SELECT eggSize, quantity FROM eggproduction WHERE eggBatch_ID = '$eggBatch_ID'";
        $stmt = $conn->query($sql);

        if($stmt){
            if($stmt->rowCount() > 0){
                while($row = $stmt->fetch()){
                    $productionQuantity = $row['quantity'];
                    $eggSize = $row['eggSize'];
                }
                // Free result set
                unset($result);
            } else{
                echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
            }
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }

        if($quantity > $productionQuantity){
            $quantity_err = "Reduction quantity is greater than the stock available. Stock available is only "  .  $productionQuantity . ".";
        }else{
            $newQuantity = $productionQuantity - $quantity;
        }
        }

        //validate reduction type if empty and allows only alphabets and white spaces
        if (empty(trim($reductionType))) {  
            $reductionType_err = "Please select a reduction type.";
        }

        //validate reduction date
        if (empty($dateReduced)){
            $dateReduced_err = "Please enter date reduced.";
        }


        if(empty($eggBatch_ID_err) && empty($quantity_err) && empty($reductionType_err) && empty($dateReduced_err)){
           
           // Prepare an insert statement
           $sql = "INSERT INTO eggreduction (eggBatch_ID, eggSize, quantity, reductionType, dateReduced) VALUES (:eggBatch_ID, :eggSize, :quantity, :reductionType, :dateReduced)";
         
           if($stmt = $conn->prepare($sql))
           {
               // Bind variables to the prepared statement as parameters
               $stmt->bindParam(":eggBatch_ID", $param_eggBatch_ID, PDO::PARAM_STR);
               $stmt->bindParam(":eggSize", $param_eggSize, PDO::PARAM_STR);
               $stmt->bindParam(":quantity", $param_quantity, PDO::PARAM_STR);
               $stmt->bindParam(":reductionType", $param_reductionType, PDO::PARAM_STR);
               $stmt->bindParam(":dateReduced", $param_dateReduced, PDO::PARAM_STR);

               // Set parameters
               $param_eggBatch_ID = $eggBatch_ID;
               $param_eggSize = $eggSize;
               $param_quantity = $quantity;
               $param_reductionType = $reductionType;
               $param_dateReduced = $dateReduced;
               // Attempt to execute the prepared statement
               if($stmt->execute())
               {
                
                    // Prepare an update statement to update 
                    $sql = "UPDATE eggproduction SET quantity=:newQuantity WHERE eggBatch_ID = '$eggBatch_ID'";
                    
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

                $_SESSION['status'] = "Reduction Added Successfully.";
                header("Location: egg_reduction.php");
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