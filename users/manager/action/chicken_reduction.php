<?php
//database connection, located in the config directory
include('../../../config/database_connection.php');

try{

    //define variables
    $chickenBatch_ID = $coopNumber = $batchName = $quantity = $reductionType = $dateReduced = $success = $newQuantity = $inStock = "";

    //variables to store error message
    $chickenBatch_ID_err = $coopNumber_err = $batchName_err = $quantity_err = $reductionType_err = $dateReduced_err = "";
    
    //processing the data from the form submitted
    if(isset($_POST['submit'])){

        //collect data from the form
        $coopNumber = $_POST['coopNumber'];
        $quantity = $_POST['quantity'];
        $reductionType = $_POST['reductionType'];
        $dateReduced = $_POST['dateReduced'];
    
        //validate coop number and only accept numeric input
        if (!empty(trim($coopNumber))) {  
            //statement to select the all the medicine names
            $sql = "SELECT chickenBatch_ID, batchName FROM chickenproduction WHERE coopNumber = '$coopNumber'";
            $stmt = $conn->query($sql);
            if($stmt){
                if($stmt->rowCount() > 0){
                    while($row = $stmt->fetch()){
                        $chickenBatch_ID = $row['chickenBatch_ID'];
                        $batchName = $row['batchName'];
                    }
                    // Free result set
                    unset($result);
                } else{
                    echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        else {  
            $coopNumber_err = "Please select coop number.";
        }
        
        
        //validate starting quantity if empty
        if (!preg_match ("/^[0-9]+$/", $quantity) ){  
            $quantity_err = "Please enter a valid quantity."; 
        }
        else if(!empty($quantity)){
            //statement to select the all the medicine names
            $sql = "SELECT inStock FROM chickenproduction WHERE coopNumber = '$coopNumber'";
            $stmt = $conn->query($sql);

            if($stmt){
                if($stmt->rowCount() > 0){
                    while($row = $stmt->fetch()){
                        $inStock = $row['inStock'];
                    }
                    // Free result set
                    unset($result);
                } else{
                    echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            if($quantity > $inStock){
                $quantity_err = "Reduction quantity is greater than the stock available. Stock available is only "  .  $inStock . ".";
            }else{
                $newQuantity = $inStock - $quantity;
            }
        }

        //validate reduction type if empty and allows only alphabets and white spaces
        if (empty(trim($reductionType))) {  
            $reductionType_err = "Please select reduction type.";
        }

        //validate reduction date
        if (empty($dateReduced)){
            $dateReduced_err = "Please enter date";
        }


        if(empty($coopNumber_err) && empty($quantity_err) && empty($reductionType_err) && empty($dateReduced_err)){
            
           // Prepare an insert statement
           $sql = "INSERT INTO chickenreduction (chickenBatch_ID, coopNumber, batchName, quantity, reductionType, dateReduced) VALUES (:chickenBatch_ID, :coopNumber, :batchName, :quantity, :reductionType, :dateReduced)";
         
           if($stmt = $conn->prepare($sql))
           {
               // Bind variables to the prepared statement as parameters
               $stmt->bindParam(":chickenBatch_ID", $param_chickenBatch_ID, PDO::PARAM_STR);
               $stmt->bindParam(":coopNumber", $param_coopNumber, PDO::PARAM_STR);
               $stmt->bindParam(":batchName", $param_batchName, PDO::PARAM_STR);
               $stmt->bindParam(":quantity", $param_quantity, PDO::PARAM_STR);
               $stmt->bindParam(":reductionType", $param_reductionType, PDO::PARAM_STR);
               $stmt->bindParam(":dateReduced", $param_dateReduced, PDO::PARAM_STR);

               // Set parameters
               $param_chickenBatch_ID = $chickenBatch_ID;
               $param_coopNumber = $coopNumber;
               $param_batchName = $batchName;
               $param_quantity = $quantity;
               $param_reductionType = $reductionType;
               $param_dateReduced = $dateReduced;
               // Attempt to execute the prepared statement
               if($stmt->execute())
               {
                    
                    // Prepare an update statement to update inStock
                    $sql = "UPDATE chickenproduction SET inStock=:newQuantity WHERE coopNumber = '$coopNumber'";
                    
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
                    header("Location: chicken_reduction.php");
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