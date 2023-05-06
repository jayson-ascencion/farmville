<?php
//database connection, located in the config directory
include('../../../config/database_connection.php');

try{

    //define variables
    $medicine_ID = $medicineName = $quantity = $dateAdded =  $expirationDate = $success = $futureDate = "";

    //variables to store error message
    $medicine_ID_err = $medicineName_err = $quantity_err = $dateAdded_err = $expirationDate_err = "";
    
    //processing the data from the form submitted
    if(isset($_POST['submit'])){

        //collect data from the form
        $user_ID = $_SESSION['user_ID'];
        $medicine_ID = $_POST['medicine_ID'];
        $quantity = $_POST['quantity'];
        $dateAdded = $_POST['dateAdded'];
        $expirationDate = $_POST['expirationDate'];
        $transactionType = 'replenishment';
    
    
        //validate medicine type if empty and only allows only alphabets and white spaces
        // if (!preg_match('/^[\p{L} ]+$/u', trim($medicine_ID)) ) {  
        //    $medicine_ID_err = "Only alphabets and whitespace are allowed.";
        // }
        // else 
        if (empty(trim($medicine_ID))) {  
            $medicine_ID_err = "Please select medicine.";
        }else{
            $sql = "SELECT * FROM medicines WHERE medicine_ID = $medicine_ID";
            $stmt = $conn->query($sql);
            if($stmt){
                if($stmt->rowCount() > 0){
                    while($row = $stmt->fetch()){
                        $medicineName = $row['medicineName'];
                    }
                }
            }
        }
        
        //validate medicine name if empty and allows only alphabets and white spaces
        // if (empty(trim($medicineName))) {  
        //     $medicineName_err = "Please enter medicine name.";
        // }

        //validate medicine brand if empty and allows only alphabets and white spaces
        // if (!preg_match('/^[\p{L} ]+$/u', $medicineBrand) ) {  
        //     $medicineBrand_err = "Only alphabets and whitespace are allowed."; 
        // }
        // else 

        //validate starting quantity if empty and only allows number with a length of 11, validate if number exist then display error
        if (!preg_match ("/^[0-9]+$/", $quantity) ){  
            $quantity_err = "Please enter a valid quantity."; 
        }

        //validate in stock quantity if empty and only allows number with a length of 11, validate if number exist then display error
        // if (!preg_match ("/^[0-9]+$/", $quantity) ){  
        //     $quantity = "Please enter a valid quantity."; 
        // }

        //validate date added if empty
        if (empty($dateAdded)){
            $dateAdded_err = "Please enter a date";
        }

        //validate expiration date if empty
        if (empty($expirationDate)){
            $expirationDate_err = "Please enter a date";
        }
        

        if(empty($medicine_ID_err) && empty($quantity_err) && empty($dateAdded_err) && empty($expirationDate_err)){

           // Prepare an insert statement
           $sql = "INSERT INTO medicinetransaction (medicine_ID, medicineName, quantity, transactionDate, expirationDate, user_ID, transactionType) VALUES (:medicine_ID, :medicineName, :quantity, :dateAdded, :expirationDate, :user_ID, :transactionType)";
         
           if($stmt = $conn->prepare($sql))
           {
               // Bind variables to the prepared statement as parameters
               $stmt->bindParam(":medicine_ID", $param_medicine_ID, PDO::PARAM_STR);
               $stmt->bindParam(":medicineName", $param_medicineName, PDO::PARAM_STR);
               $stmt->bindParam(":quantity", $param_quantity, PDO::PARAM_STR);
               $stmt->bindParam(":dateAdded", $param_dateAdded, PDO::PARAM_STR);
               $stmt->bindParam(":expirationDate", $param_expirationDate, PDO::PARAM_STR);
               $stmt->bindParam(":user_ID", $param_user_ID, PDO::PARAM_STR);
               $stmt->bindParam(":transactionType", $param_transactionType, PDO::PARAM_STR);

               // Set parameters
               $param_medicine_ID = $medicine_ID;
               $param_medicineName = $medicineName;
               $param_quantity = $quantity;
               $param_dateAdded = $dateAdded;
               $param_expirationDate = $expirationDate;
               $param_user_ID = $user_ID;
               $param_transactionType = $transactionType;
               // Attempt to execute the prepared statement
               if($stmt->execute())
               {
                // Prepare an update statement to update inStock
                $sql = "UPDATE medicines SET inStock = inStock + :quantity, expirationDate=:expirationDate WHERE medicine_ID = '$medicine_ID'";
            
                if($stmt = $conn->prepare($sql))
                {
                    // Bind variables to the prepared statement as parameters
                    $stmt->bindParam(":quantity", $param_quantity, PDO::PARAM_STR);
                    $stmt->bindParam(":expirationDate", $param_expirationDate, PDO::PARAM_STR);

                    // Set parameters
                    $param_quantity = $quantity;
                    $param_expirationDate = $expirationDate;
                    // Attempt to execute the prepared statement
                    $stmt->execute();

                    // Close statement
                    unset($stmt);
                }
                $_SESSION['status'] = "Medicine Stock Added Successfully.";
                header("Location: medicines.php");
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