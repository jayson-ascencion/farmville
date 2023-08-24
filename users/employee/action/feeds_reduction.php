<?php
//database connection, located in the config directory
include('../../../config/database_connection.php');

try{
 
    //define variables
    $feed_ID = $feedName = $quantity = $reductionType = $dateReduced = $success = $newQuantity =  $productionQuantity = "";

    //variables to store error message
    $feed_ID_err = $feedName_err = $quantity_err = $reductionType_err = $dateReduced_err = "";
    
    //processing the data from the form submitted
    if(isset($_POST['submit'])){

        //collect data from the form
        $feed_ID = $_POST['feed_ID'];
        $quantity = $_POST['quantity'];
        $reductionType = $_POST['reductionType'];
        $dateReduced = $_POST['dateReduced'];
        $user_ID = $_SESSION['user_ID'];
        //validate egg batch ID
        if(empty($feed_ID)){
            $feed_ID_err = "Please select a feed";
        }
        
        //validate quantity if empty
        if (!preg_match ("/^[0-9]+$/", $quantity) ){  
            $quantity_err = "Please enter a valid quantity."; 
        }
        else if($quantity<1){
            $quantity_err = "Please enter a valid quantity."; 
        }
        else if(!empty($quantity)){
            //statement to quantity in feeds
            $sql = "SELECT feedName, inStock FROM feeds WHERE feed_ID = '$feed_ID'";
            $stmt = $conn->query($sql);

            if($stmt){
                if($stmt->rowCount() > 0){
                    while($row = $stmt->fetch()){
                        $productionQuantity = $row['inStock'];
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

            if($quantity > $productionQuantity){
                $quantity_err = "Reduction quantity is greater than the stock available. Stock available is only "  .  $productionQuantity . ".";
            }else{
                $newQuantity = $productionQuantity - $quantity;
            }
        }


        //validate reduction type if empty and allows only alphabets and white spaces
        if (empty($reductionType)) {  
            $reductionType_err = "Please select reduction type.";
        }

        //validate reduction date
        if (empty($dateReduced)){
            $dateReduced_err = "Please enter a date";
        }


        if(empty($feed_ID_err) && empty($quantity_err) && empty($reductionType_err) && empty($dateReduced_err)){

           // Prepare an insert statement
           $sql = "INSERT INTO feedtransaction (feed_ID, user_ID, feedName, quantity, reductionType, transactionDate) VALUES (:feed_ID, :user_ID, :feedName, :quantity, :reductionType, :dateReduced)";
         
           if($stmt = $conn->prepare($sql))
           {
               // Bind variables to the prepared statement as parameters
               $stmt->bindParam(":feed_ID", $param_feed_ID, PDO::PARAM_STR);
               $stmt->bindParam(":user_ID", $param_user_ID, PDO::PARAM_STR);
               $stmt->bindParam(":feedName", $param_feedName, PDO::PARAM_STR);
               $stmt->bindParam(":quantity", $param_quantity, PDO::PARAM_STR);
               $stmt->bindParam(":reductionType", $param_reductionType, PDO::PARAM_STR);
               $stmt->bindParam(":dateReduced", $param_dateReduced, PDO::PARAM_STR);

               // Set parameters
               $param_feed_ID = $feed_ID;
               $param_user_ID = $user_ID;
               $param_feedName = $feedName;
               $param_quantity = $quantity;
               $param_reductionType = $reductionType;
               $param_dateReduced = $dateReduced;
               // Attempt to execute the prepared statement
               if($stmt->execute())
               {
                
                    // Prepare an update statement to update 
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

                $_SESSION['status'] = "Reduction Added Successfully.";
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