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

        //collect data from the form
        $feed_ID = $_POST['feed_ID'];
        $quantity = $_POST['quantity'];
        // $inStock = $_POST['inStock'];
        $datePurchased = $_POST['datePurchased'];
        $transactionType = 'replenishment';
        $user_ID = $_SESSION['user_ID'];
        //validate feedName if empty and only allows only alphabets and white spaces
        // if (!preg_match('/^[\p{L} ]+$/u', trim($feedName)) ) {  
        //    $feedName_err = "Only alphabets and whitespace are allowed.";
        // }
        // else 
        if (empty(trim($feed_ID))) {  
            $feed_ID_err = "Please enter feed name.";
        }else{
            $sql = "SELECT * FROM feeds WHERE feed_ID = $feed_ID";
            $stmt = $conn->query($sql);
            if($stmt){
                if($stmt->rowCount() > 0){
                    while($row = $stmt->fetch()){
                        $feedName = $row['feedName'];
                    }
                }
            }
        }

        //validate starting quantity if empty and only allows number with a length of 11, validate if number exist then display error
        if (!preg_match ("/^[0-9]+$/", $quantity) ){  
            $quantity_err = "Please enter a valid quantity."; 
        }
        else if(empty($quantity)){
            $quantity_err = "Please enter a quantity";
        }

        //validate starting quantity if empty and only allows number with a length of 11, validate if number exist then display error
        // if (!preg_match ("/^[0-9]+$/", $inStock) ){  
        //     $inStock_err = "Please enter a valid quantity."; 
        // }
        // else if(empty($inStock)){
        //     $inStock_err = "Please enter a quantity";
        // }

        if (empty(trim($datePurchased))) {  
            $datePurchased_err = "Please enter a date.";
        }

        if(empty($feed_ID_err) && empty($quantity_err) && empty($datePurchased_err)){

           // Prepare an insert statement
           $sql = "INSERT INTO feedtransaction (feed_ID, user_ID, feedName, quantity, transactionDate, transactionType) VALUES (:feed_ID, :user_ID, :feedName, :quantity, :datePurchased, :transactionType)";
         
           if($stmt = $conn->prepare($sql))
           {
               // Bind variables to the prepared statement as parameters
               $stmt->bindParam(":feed_ID", $param_feed_ID, PDO::PARAM_STR);
               $stmt->bindParam(":user_ID", $param_user_ID, PDO::PARAM_STR);
               $stmt->bindParam(":feedName", $param_feedName, PDO::PARAM_STR);
               $stmt->bindParam(":quantity", $param_quantity, PDO::PARAM_STR);
            //    $stmt->bindParam(":inStock", $param_inStock, PDO::PARAM_STR);
               $stmt->bindParam(":datePurchased", $param_datePurchased, PDO::PARAM_STR);
               $stmt->bindParam(":transactionType", $param_transactionType, PDO::PARAM_STR);

               // Set parameters
               $param_feed_ID = $feed_ID;
               $param_user_ID = $user_ID;
               $param_feedName = $feedName;
               $param_quantity = $quantity;
            //    $param_inStock = $inStock;
               $param_datePurchased = $datePurchased;
               $param_transactionType = $transactionType;

               // Attempt to execute the prepared statement
               if($stmt->execute())
               {
                // Prepare an update statement to update inStock
                $sql = "UPDATE feeds SET inStock = inStock + :quantity WHERE feed_ID = '$feed_ID'";
        
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
                $_SESSION['status'] = "Feed Stock Added Successfully.";
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