<?php
//database connection, located in the config directory
include('../../../config/database_connection.php');
    $id = $_REQUEST['id'];

    //this will hold the quantity before update
    $oldQuantity = "";

    //statement to get the old quantity
    $sql = "SELECT quantity FROM chickenreduction WHERE reduction_ID = '$id'";
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

try{

    //define variables
    $coopNumber = $updateQuantity = $reductionType = $dateReduced = $diff = "";

    //this will hold the quantity in stock
    $inStock = "";

    //this will will the difference between the update quantity and old quantity
    $diff = "";

    //this will hold the new quantity for instock after adding/subtracting update and old quantity
    $newQuantity = "";

    //variables to store error message
    $coopNumber_err = $updateQuantity_err = $reductionType_err = $dateReduced_err  = "";
    
    //processing the data from the form submitted
    if(isset($_POST['submit'])){
        $id = $_REQUEST['id'];

        //collect data from the form
        $chickenBatch_ID = $_POST['chickenBatch_ID'];
        $coopNumber = $_POST['coopNumber'];
        $updateQuantity = $_POST['quantity'];
        $reductionType = $_POST['reductionType'];
        $dateReduced = $_POST['dateReduced'];
    
    
        //validate coop number and only accept numeric input
        // if (!preg_match ("/^[0-9]*$/", trim($coopNumber)) ) {  
        //    $coopNumber_err = "Only alphabets and whitespace are allowed.";
        // }
        // else if (empty(trim($coopNumber))) {  
        //     $coopNumber_err = "Please enter coop number.";
        // }

        //statement to get the in stock
        $sql = "SELECT inStock FROM chickenproduction WHERE chickenBatch_ID = '$chickenBatch_ID'";
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
        
        //validate update quantity
        if (!preg_match ("/^[0-9]*$/", $updateQuantity) ){  
            $updateQuantity_err = "Please enter a valid quantity."; 
        }else if(!empty($updateQuantity) && $updateQuantity >= 0){

            
            if($updateQuantity == $oldQuantity){
                $newQuantity = $inStock;
            }
            else if($updateQuantity > $oldQuantity){
                $diff = $updateQuantity - $oldQuantity;

                if($diff > $inStock){
                    $updateQuantity_err = "Quantity is greater than the stock available. Stock available is only " . $inStock . ".";
                }else{
                    $newQuantity = $inStock - $diff;
                }

            }else if($updateQuantity < $oldQuantity){
                $diff = $oldQuantity - $updateQuantity;

                $newQuantity = $inStock + $diff;
            }
        }else if($updateQuantity < 0){
            $updateQuantity_err = "Please enter a valid quantitys";
        }

        //validate starting quantity if empty
        if (empty($dateReduced) ){  
            $dateReduced_err = "Please enter date acquired."; 
        }

        //validate acquisitionType
        if (empty($reductionType)){
            $reductionType_err = "Please select batch purpose";
        }


        if(empty($coopNumber_err) && empty($updateQuantity_err) && empty($dateReduced_err) && empty($reductionType_err)){

           // Prepare an insert statement
           $sql = "UPDATE chickenreduction SET quantity=:updateQuantity, reductionType=:reductionType, dateReduced=:dateReduced WHERE reduction_ID = '$id'";
         
           if($stmt = $conn->prepare($sql))
           {
               // Bind variables to the prepared statement as parameters
            //    $stmt->bindParam(":coopNumber", $param_coopNumber, PDO::PARAM_STR);
               $stmt->bindParam(":updateQuantity", $param_updateQuantity, PDO::PARAM_STR);
               $stmt->bindParam(":reductionType", $param_reductionType, PDO::PARAM_STR);
               $stmt->bindParam(":dateReduced", $param_dateReduced, PDO::PARAM_STR);

               // Set parameters
            //    $param_coopNumber = $coopNumber;
                $param_updateQuantity = $updateQuantity;
               $param_reductionType = $reductionType;
               $param_dateReduced = $dateReduced;
               // Attempt to execute the prepared statement
               if($stmt->execute())
               {
                    // Prepare an update statement to update inStock
                    $sql = "UPDATE chickenproduction SET inStock=:newQuantity WHERE chickenBatch_ID = '$chickenBatch_ID'";
                    
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
                $_SESSION['status'] = "Chicken Reduction Details Successfully Updated.";
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