<?php
//database connection, located in the config directory
include('../../../config/database_connection.php');

try{

    //define variables
    $feedName = $brand = $startingQuantity = $inStock = $datePurchased = "";

    //variables to store error message
    $feedName_err = $brand_err = $startingQuantity_err = $inStock_err = $datePurchased_err = "";

    //processing the data from the form submitted
    if(isset($_POST['submit'])){

        //collect data from the form
        $feedName = $_POST['feedName'];
        $brand = $_POST['brand'];
        $startingQuantity = $_POST['startingQuantity'];
        $inStock = $_POST['inStock'];
        $datePurchased = $_POST['datePurchased'];
    
        //validate feedName if empty and only allows only alphabets and white spaces
        // if (!preg_match('/^[\p{L} ]+$/u', trim($feedName)) ) {  
        //    $feedName_err = "Only alphabets and whitespace are allowed.";
        // }
        // else 
        if (empty(trim($feedName))) {  
            $feedName_err = "Please enter feed name.";
        }
        
        //validate brand if empty and allows only alphabets and white spaces
        // if (!preg_match('/^[\p{L} ]+$/u', $brand) ) {  
        //     $brand_err = "Only alphabets and whitespace are allowed."; 
        // }
        // else 
        if (empty(trim($brand))) {  
            $brand_err = "Please enter brand name.";
        }

        //validate starting quantity if empty and only allows number with a length of 11, validate if number exist then display error
        if (!preg_match ("/^[0-9]+$/", $startingQuantity) ){  
            $startingQuantity_err = "Please enter a valid quantity."; 
        }
        else if(empty($startingQuantity)){
            $startingQuantity_err = "Please enter a quantity";
        }

        //validate starting quantity if empty and only allows number with a length of 11, validate if number exist then display error
        if (!preg_match ("/^[0-9]+$/", $inStock) ){  
            $inStock_err = "Please enter a valid quantity."; 
        }
        else if(empty($inStock)){
            $inStock_err = "Please enter a quantity";
        }

        if (empty(trim($datePurchased))) {  
            $datePurchased_err = "Please enter a date.";
        }

        if(empty($feedName_err) && empty($brand_err) && empty($startingQuantity_err) && empty($inStock_err)  && empty($datePurchased_err)){

           // Prepare an insert statement
           $sql = "INSERT INTO feeds (feedName, brand, startingQuantity, inStock, datePurchased) VALUES (:feedName, :brand, :startingQuantity, :inStock, :datePurchased)";
         
           if($stmt = $conn->prepare($sql))
           {
               // Bind variables to the prepared statement as parameters
               $stmt->bindParam(":feedName", $param_feedName, PDO::PARAM_STR);
               $stmt->bindParam(":brand", $param_brand, PDO::PARAM_STR);
               $stmt->bindParam(":startingQuantity", $param_startingQuantity, PDO::PARAM_STR);
               $stmt->bindParam(":inStock", $param_inStock, PDO::PARAM_STR);
               $stmt->bindParam(":datePurchased", $param_datePurchased, PDO::PARAM_STR);

               // Set parameters
               $param_feedName = $feedName;
               $param_brand = $brand;
               $param_startingQuantity = $startingQuantity;
               $param_inStock = $inStock;
               $param_datePurchased = $datePurchased;

               // Attempt to execute the prepared statement
               if($stmt->execute())
               {
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