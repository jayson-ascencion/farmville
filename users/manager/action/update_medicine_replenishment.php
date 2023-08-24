<?php
//database connection, located in the config directory
include('../../../config/database_connection.php');

$id = $_REQUEST['id'];
$sql = "SELECT medicine_ID, quantity FROM medicinetransaction WHERE transaction_ID = $id";
$stmt = $conn->query($sql);
if($stmt){
    if($stmt->rowCount() > 0){
        while($row = $stmt->fetch()){
            $old_medicine_ID = $row['medicine_ID'];
            $old_quantity = $row['quantity'];
        }
    }
}

try{

    //define variables
    $medicine_ID = $medicineName = $quantity = $dateAdded = $expirationDate = $success = $futureDate = "";

    //variables to store error message
    $medicine_ID_err = $medicineName_err = $quantity_err = $dateAdded_err = $expirationDate_err = "";
    
    //processing the data from the form submitted
    if(isset($_POST['submit'])){
        $id = $_REQUEST['id'];

        //collect data from the form
        $medicine_ID = $_POST['medicine_ID'];
        $quantity = $_POST['quantity'];
        $dateAdded = $_POST['dateAdded'];
        $expirationDate = $_POST['expirationDate'];
    
    
        //validate medicine type if empty and only allows only alphabets and white spaces
        // if (!preg_match('/^[\p{L} ]+$/u', trim($medicineType)) ) {  
        //    $medicineType_err = "Only alphabets and whitespace are allowed.";
        // }
        // // else 
        // if (empty(trim($medicineType))) {  
        //     $medicineType_err = "Please enter medicine type.";
        // }
        
        //validate medicine name if empty and allows only alphabets and white spaces
        // if (!preg_match('/^[\p{L} ]+$/u', $medicineName) ) {  
        //     $medicineName_err = "Only alphabets and whitespace are allowed."; 
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

        //validate starting quantity if empty and only allows number with a length of 11, validate if number exist then display error
        // if (!preg_match ("/^[0-9]+$/", $quantity) ){  
        //     $quantity_err = "Please enter a valid quantity."; 
        // }

        // validate starting quantity if empty and only allows number with a length of 11, validate if number exist then display error
        if (!preg_match ("/^[0-9]+$/", $quantity) ){  
            $quantity_err = "Please enter a valid quantity."; 
        }

        //validate date added if empty
        if (empty($dateAdded)){
            $dateAdded_err = "Please enter a date";
        }

        //validate expiration date if empty
        if (empty($expirationDate)){
            $expirationDate_err = "Please enter a date";
        }

        if(empty($medicine_id_err) && empty($quantity_err) && empty($dateAdded_err) && empty($expirationDate_err)){

           // Prepare an insert statement
           $sql = "UPDATE medicinetransaction SET medicine_ID=:medicine_ID, medicineName=:medicineName, quantity=:quantity, transactionDate=:dateAdded, expirationDate=:expirationDate WHERE transaction_ID = '$id'";
         
           if($stmt = $conn->prepare($sql))
           {
               // Bind variables to the prepared statement as parameters
               $stmt->bindParam(":medicine_ID", $param_medicine_ID, PDO::PARAM_STR);
               $stmt->bindParam(":medicineName", $param_medicineName, PDO::PARAM_STR);
            //    $stmt->bindParam(":medicineBrand", $param_medicineBrand, PDO::PARAM_STR);
            //    $stmt->bindParam(":medicineFor", $param_medicineFor, PDO::PARAM_STR);
            //    $stmt->bindParam(":quantity", $param_startingQuantity, PDO::PARAM_STR);
               $stmt->bindParam(":quantity", $param_quantity, PDO::PARAM_STR);
               $stmt->bindParam(":dateAdded", $param_dateAdded, PDO::PARAM_STR);
               $stmt->bindParam(":expirationDate", $param_expirationDate, PDO::PARAM_STR);

               // Set parameters
               $param_medicine_ID = $medicine_ID;
               $param_medicineName = $medicineName;
            //    $param_medicineBrand = $medicineBrand;
            //    $param_medicineFor = $medicineFor;
            //    $param_startingQuantity = $quantity;
               $param_quantity = $quantity;
               $param_dateAdded = $dateAdded;
               $param_expirationDate = $expirationDate;
               // Attempt to execute the prepared statement
               if($stmt->execute())
               {
                    // Prepare an update statement to update quantity
                    $sql = "UPDATE medicines SET expirationDate=:expirationDate WHERE medicine_ID = '$medicine_ID'";
        
                    if($stmt = $conn->prepare($sql))
                    {
                        // Bind variables to the prepared statement as parameters
                        $stmt->bindParam(":expirationDate", $param_expirationDate, PDO::PARAM_STR);

                        // Set parameters
                        $param_medicineName = $expirationDate;
                        // Attempt to execute the prepared statement
                        $stmt->execute();

                        // Close statement
                        unset($stmt);
                    }
                    if($medicine_ID == $old_medicine_ID){
                        if($quantity > $old_quantity){
                            $diff = $quantity - $old_quantity;
                            $stmt = $conn->prepare('UPDATE medicines SET inStock = inStock + :diff  WHERE medicine_ID = :old_medicine_ID');
                            $stmt->bindValue(':diff', $diff, PDO::PARAM_INT);
                            $stmt->bindValue(':old_medicine_ID', $old_medicine_ID, PDO::PARAM_STR);
                            $stmt->execute();
                        }else{
                            $diff = $old_quantity - $quantity;
                            $stmt = $conn->prepare('UPDATE medicines SET inStock = inStock - :diff  WHERE medicine_ID = :old_medicine_ID');
                            $stmt->bindValue(':diff', $diff, PDO::PARAM_INT);
                            $stmt->bindValue(':old_medicine_ID', $old_medicine_ID, PDO::PARAM_STR);
                            $stmt->execute();
                        }
                    }else if ($medicine_ID != $old_medicine_ID) {
                            $stmt = $conn->prepare('UPDATE medicines SET inStock = inStock - :old_quantity  WHERE medicine_ID = :old_medicine_ID');
                            $stmt->bindValue(':old_quantity', $old_quantity, PDO::PARAM_INT);
                            $stmt->bindValue(':old_medicine_ID', $old_medicine_ID, PDO::PARAM_STR);
                            $stmt->execute();
                        
                            // Add quantity to new ID
                            $stmt = $conn->prepare('UPDATE medicines SET inStock = inStock + :quantity WHERE medicine_ID = :medicine_ID');
                            $stmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);
                            $stmt->bindValue(':medicine_ID', $medicine_ID, PDO::PARAM_STR);
                            $stmt->execute();
                        // }
                        
                    }

                $_SESSION['status'] = "Medicine Stock Details Successfully Updated.";
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
