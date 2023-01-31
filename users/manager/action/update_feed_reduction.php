<?php
//database connection, located in the config directory
include('../../../config/database_connection.php');
    $id = $_REQUEST['id'];

    //this will hold the quantity before update
    $oldQuantity = "";

    //statement to get the old quantity
    $sql = "SELECT quantity FROM feedreduction WHERE feedReduction_ID = '$id'";
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
    $feed_ID = $feedName = $updateQuantity = $reductionType = $dateReduced = $success = "";

    //this will hold the quantity in stock
    $inStock = "";

    //this will will the difference between the update quantity and old quantity
    $diff = "";

    //this will hold the new quantity for instock after adding/subtracting update and old quantity
    $newQuantity = "";

    //variables to store error message
    $feed_ID_err = $updateQuantity_err = $reductionType_err = $dateReduced_err = "";
    
    //processing the data from the form submitted
    if(isset($_POST['submit'])){
        $id = $_REQUEST['id'];

        //collect data from the form
        $feed_ID = $_POST['feed_ID'];
        $updateQuantity = $_POST['updateQuantity'];
        $reductionType = $_POST['reductionType'];
        $dateReduced = $_POST['dateReduced'];
        
        
        //statement to get the in stock in the egg production using egg batch id
        $sql = "SELECT inStock, feedName FROM feeds WHERE feed_ID = '$feed_ID'";
        $stmt = $conn->query($sql);

        if($stmt){
            if($stmt->rowCount() > 0){
                while($row = $stmt->fetch()){
                    $inStock = $row['inStock'];
                    $feedName = $row['feedName'];

                }
                // Free result set
                unset($result);
            } else{
                echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
            }
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }

        //validate updateQuantity
        if (!preg_match ("/^[0-9]*$/", $updateQuantity)) {  
            $updateQuantity_err = "Please enter a valid quantity."; 
        }
        else if (empty($updateQuantity)) {  
            $updateQuantity_err = "Please enter quantity.";
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

        //validate reduction type
        if (empty(trim($reductionType))) {  
            $reductionType_err = "Please enter reduction type.";
        }

        //validate dateReduced
        if (empty($dateReduced)){
            $dateReduced_err = "Please select a date";
        }

        if(empty($feed_ID_err) && empty($updateQuantity_err) && empty($reductionType_err) && empty($dateReduced_err)){

           // Prepare an insert statement
           $sql = "UPDATE feedreduction SET feed_ID=:feed_ID, quantity=:updateQuantity, reductionType=:reductionType, dateReduced=:dateReduced WHERE feedReduction_ID = '$id'";
         
           if($stmt = $conn->prepare($sql))
           {
               // Bind variables to the prepared statement as parameters
               $stmt->bindParam(":feed_ID", $param_feed_ID, PDO::PARAM_STR);
               $stmt->bindParam(":updateQuantity", $param_updateQuantity, PDO::PARAM_STR);
               $stmt->bindParam(":reductionType", $param_reductionType, PDO::PARAM_STR);
               $stmt->bindParam(":dateReduced", $param_dateReduced, PDO::PARAM_STR);

               // Set parameters
               $param_feed_ID = $feed_ID;
               $param_updateQuantity = $updateQuantity;
               $param_reductionType = $reductionType;
               $param_dateReduced = $dateReduced;

               // Attempt to execute the prepared statement
               if($stmt->execute())
               {
                    // Prepare an update statement to update inStock
                    $sql = "UPDATE feeds SET inStock=:newQuantity WHERE feed_ID = '$feed_ID'";
        
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
                $_SESSION['status'] = "Feed Reduction Details Successfully Updated.";
                header("Location: feed_reduction.php");
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