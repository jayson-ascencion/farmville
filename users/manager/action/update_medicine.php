<?php
//database connection, located in the config directory
include('../../../config/database_connection.php');

try{

    //define variables
    $medicineType = $medicineName = $medicineBrand = $medicineFor = $startingQuantity = $inStock = $dateAdded =  $expirationDate = $success = $futureDate = "";

    //variables to store error message
    $medicineType_err = $medicineName_err = $medicineBrand_err = $medicineFor_err = $startingQuantity_err = $inStock_err = $dateAdded_err = $expirationDate_err = "";
    
    //processing the data from the form submitted
    if(isset($_POST['submit'])){
        $id = $_REQUEST['id'];

        //collect data from the form
        $medicineType = $_POST['medicineType'];
        $medicineName = $_POST['medicineName'];
        $medicineBrand = $_POST['medicineBrand'];
        $medicineFor = $_POST['medicineFor'];
        $startingQuantity = $_POST['startingQuantity'];
        $inStock = $_POST['inStock'];
        $dateAdded = $_POST['dateAdded'];
        $expirationDate = $_POST['expirationDate'];
    
    
        //validate medicine type if empty and only allows only alphabets and white spaces
        // if (!preg_match('/^[\p{L} ]+$/u', trim($medicineType)) ) {  
        //    $medicineType_err = "Only alphabets and whitespace are allowed.";
        // }
        // else 
        if (empty(trim($medicineType))) {  
            $medicineType_err = "Please enter medicine type.";
        }
        
        //validate medicine name if empty and allows only alphabets and white spaces
        // if (!preg_match('/^[\p{L} ]+$/u', $medicineName) ) {  
        //     $medicineName_err = "Only alphabets and whitespace are allowed."; 
        // }
        // else 
        if (empty(trim($medicineName))) {  
            $medicineName_err = "Please enter medicine name.";
        }

        //validate medicine brand if empty and allows only alphabets and white spaces
        // if (!preg_match('/^[\p{L} ]+$/u', $medicineBrand) ) {  
        //     $medicineBrand_err = "Only alphabets and whitespace are allowed."; 
        // }
        // else
        if (empty(trim($medicineBrand))) {  
            $medicineBrand_err = "Please enter medicine brand.";
        }

        //validate medicineFor
        if (empty($medicineFor)){
            $medicineFor_err = "Please select a medicine unit";
        }

        //validate starting quantity if empty and only allows number with a length of 11, validate if number exist then display error
        if (!preg_match ("/^[0-9]+$/", $startingQuantity) ){  
            $startingQuantity_err = "Please enter a valid quantity."; 
        }

        //validate starting quantity if empty and only allows number with a length of 11, validate if number exist then display error
        if (!preg_match ("/^[0-9]+$/", $inStock) ){  
            $inStock_err = "Please enter a valid quantity."; 
        }

        //validate date added if empty
        if (empty($dateAdded)){
            $dateAdded_err = "Please enter a date";
        }

        //validate expiration date if empty
        if (empty($expirationDate)){
            $expirationDate_err = "Please enter a date";
        }

        if(empty($medicineType_err) && empty($medicineName_err) && empty($medicineBrand_err) && empty($medicineFor_err) && empty($startingQuantity_err) && empty($inStock_err) && empty($dateAdded_err) && empty($expirationDate_err)){

           // Prepare an insert statement
           $sql = "UPDATE medicines SET medicineType=:medicineType, medicineName=:medicineName, medicineBrand=:medicineBrand, medicineFor=:medicineFor, startingQuantity=:startingQuantity, inStock=:inStock, dateAdded=:dateAdded, expirationDate=:expirationDate WHERE medicine_ID = '$id'";
         
           if($stmt = $conn->prepare($sql))
           {
               // Bind variables to the prepared statement as parameters
               $stmt->bindParam(":medicineType", $param_medicineType, PDO::PARAM_STR);
               $stmt->bindParam(":medicineName", $param_medicineName, PDO::PARAM_STR);
               $stmt->bindParam(":medicineBrand", $param_medicineBrand, PDO::PARAM_STR);
               $stmt->bindParam(":medicineFor", $param_medicineFor, PDO::PARAM_STR);
               $stmt->bindParam(":startingQuantity", $param_startingQuantity, PDO::PARAM_STR);
               $stmt->bindParam(":inStock", $param_inStock, PDO::PARAM_STR);
               $stmt->bindParam(":dateAdded", $param_dateAdded, PDO::PARAM_STR);
               $stmt->bindParam(":expirationDate", $param_expirationDate, PDO::PARAM_STR);

               // Set parameters
               $param_medicineType = $medicineType;
               $param_medicineName = $medicineName;
               $param_medicineBrand = $medicineBrand;
               $param_medicineFor = $medicineFor;
               $param_startingQuantity = $startingQuantity;
               $param_inStock = $inStock;
               $param_dateAdded = $dateAdded;
               $param_expirationDate = $expirationDate;
               // Attempt to execute the prepared statement
               if($stmt->execute())
               {
                    // Prepare an update statement to update inStock
                    $sql = "UPDATE medicinereduction SET medicineName=:medicineName WHERE medicine_ID = '$id'";
        
                    if($stmt = $conn->prepare($sql))
                    {
                        // Bind variables to the prepared statement as parameters
                        $stmt->bindParam(":medicineName", $param_medicineName, PDO::PARAM_STR);

                        // Set parameters
                        $param_medicineName = $medicineName;
                        // Attempt to execute the prepared statement
                        $stmt->execute();

                        // Close statement
                        unset($stmt);
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
