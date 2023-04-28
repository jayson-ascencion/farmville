<?php
//database connection, located in the config directory
include('../../../config/database_connection.php');

try{

    //define variables
    $feed_ID = $feedName = $quantity = $datePurchased = "";


    //variables to store error message
    $feed_ID_err = $quantity_err = $datePurchased_err = "";
    
    //processing the data from the form submitted
    if(isset($_POST['submit'])){
        $id = $_REQUEST['id'];

        //collect data from the form
        $feed_ID = $_POST['feed_ID'];
        $quantity = $_POST['quantity'];
        // $inStock = $_POST['inStock'];
        $datePurchased = $_POST['datePurchased'];
    
         
        //validate medicine name if empty and allows only alphabets and white spaces
        // if (!preg_match('/^[\p{L} ]+$/u', $feed_ID) ) {  
        //     $feed_ID_err = "Only alphabets and whitespace are allowed."; 
        // }
        // else 
        if (empty(trim($feed_ID))) {  
            $feed_ID_err = "Please select a feed.";
        }else{
            //statement to get the old brand
            $sql = "SELECT feedName FROM feeds WHERE feed_ID = '$feed_ID'";
            $stmt = $conn->query($sql);

            if($stmt){
                if($stmt->rowCount() > 0){
                    while($row = $stmt->fetch()){
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
        }

        //validate starting quantity if empty and only allows number with a length of 11, validate if number exist then display error
        if (!preg_match ("/^[0-9]+$/", $quantity) ){  
            $quantity_err = "Please enter a valid quantity."; 
        }

        //validate date added if empty
        if (empty($datePurchased)){
            $datePurchased_err = "Please select a date";
        }

        if(empty($feed_ID_err) && empty($quantity_err) && empty($datePurchased_err)){

        // Prepare an insert statement
        $sql = "UPDATE feedtransaction SET feed_ID=:feed_ID, feedName=:feedName, quantity=:quantity, transactionDate=:datePurchased WHERE transaction_ID = '$id'";
        
        if($stmt = $conn->prepare($sql))
        { 
            // Bind variables to the prepared statement as parameters\
            $stmt->bindParam(":feed_ID", $param_feed_ID, PDO::PARAM_STR);
            $stmt->bindParam(":feedName", $param_feedName, PDO::PARAM_STR);
            $stmt->bindParam(":quantity", $param_quantity, PDO::PARAM_STR);
            // $stmt->bindParam(":inStock", $param_inStock, PDO::PARAM_STR);
            $stmt->bindParam(":datePurchased", $param_datePurchased, PDO::PARAM_STR);

            // Set parameters
            $param_feed_ID= $feed_ID;
            $param_feedName= $feedName;
            $param_quantity = $quantity;
            // $param_inStock = $inStock;
            $param_datePurchased = $datePurchased;
            // Attempt to execute the prepared statement
            if($stmt->execute())
            {
                    // // Prepare an update statement to update inStock
                    // $sql = "UPDATE feedreduction SET feed_ID=:feed_ID WHERE feed_ID = '$id'";
        
                    // if($stmt = $conn->prepare($sql))
                    // {
                    //     // Bind variables to the prepared statement as parameters
                    //     $stmt->bindParam(":feed_ID", $param_feedName, PDO::PARAM_STR);

                    //     // Set parameters
                    //     $param_feedName = $feed_ID;
                    //     // Attempt to execute the prepared statement
                    //     $stmt->execute();

                    //     // Close statement
                    //     unset($stmt);
                    // }
                $_SESSION['status'] = "Feeds Stock Details Successfully Updated.";
                header("Location: feeds.php");
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