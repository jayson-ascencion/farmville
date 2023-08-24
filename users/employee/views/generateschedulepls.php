<?php
// Select all rows from the generateschedules table
include('../../../config/database_connection.php');
$stmt = $conn->query("SELECT * FROM generateschedules");

// Loop through the rows and insert them into the chickenproduction table
while ($row = $stmt->fetch()) {
    // Prepare an insert statement
    $sql = "INSERT INTO generateschedules (age, medicine_ID, medicineName, method) VALUES (:age, :medicine_ID, :medicineName, :method)";
    $insert_stmt = $conn->prepare($sql);
  
    // Bind variables to the prepared statement as parameters
    $insert_stmt->bindParam(":age", $row['age'], PDO::PARAM_STR);
    $insert_stmt->bindParam(":medicine_ID", $row['medicine_ID'], PDO::PARAM_STR);
    $insert_stmt->bindParam(":medicineName", $row['medicineName'], PDO::PARAM_STR);
    $insert_stmt->bindParam(":method", $row['method'], PDO::PARAM_STR);
  
    // Execute the prepared statement
    $insert_stmt->execute();
  }

// Close the connection
$conn = null;

// Redirect the user to the success page
header("Location: chicken_production.php");
exit;

//get dates from the row
// $dateAdded = $row['dateAdded'];


//date_create is used to create DateTime object  https://blog.devgenius.io/how-to-find-the-number-of-days-between-two-dates-in-php-1404748b1e84?gi=f10f685035f3 / https://stackoverflow.com/questions/2040560/finding-the-number-of-days-between-two-dates
// $today = date_create(date('Y-m-d')); //generates current date

//calculates the difference between the two dates
// $diff = date_diff($dateAdded,$today);

//store the calculated days, %r -> used to include sign and if the number is positive it will be empty, %a -> total number of days as a result from the date_diff https://www.php.net/manual/en/dateinterval.format.php
// $days = $diff->format('%r%a');

// $age = 0;

// if ($age == 0){
    //generate all vaccination scheds from age 0 to 60

// }else{
    //check the age 
// }

// Select the total number of rows in the table
// $sql = "SELECT COUNT(*) FROM mytable";
// $stmt = $conn->query($sql);
// if ($stmt) {
//   $row_count = $stmt->fetchColumn();
// }

// Use a for loop to iterate over the number of rows
// for ($i = 0; $i < $row_count; $i++) {
//     $sql = "SELECT * FROM generateschedules";
//     $stmt = $conn->query($sql);
//     if ($stmt) {
//       if ($stmt->rowCount() > 0) {
//         while ($row = $stmt->fetch()) {
//           $age[$i] = $row['age'];
//           $medicine_ID[$i] = $row['medicine_ID'];
//           $medicineName[$i] = $row['medicineName'];
//           $method[$i] = $row['method'];
//           $scheduleType[$i] = $row['type'];
//         }
        // Free result set
        // unset($result);
    //   } else {
        // echo '<div class="alert alert-danger"><em>No records were found for age ' . $age . '.</em></div>';
    //   }/
    // } else {
    //   echo "Oops! Something went wrong. Please try again later.";
    // }
    
    // for($j = 0; $i < $row_count; $j++){
    //     // Prepare an insert statement
    //     $sql = "INSERT INTO chickenproduction (age, medicine_ID, medicineName, method, scheduleType) VALUES (:age, :medicine_ID, :medicineName, :method, :scheduleType)";
         
//         if($stmt = $conn->prepare($sql))
//         {
//             // Bind variables to the prepared statement as parameters
//             $stmt->bindParam(":age", $param_age, PDO::PARAM_STR);
//             $stmt->bindParam(":medicine_ID", $param_coopNumber, PDO::PARAM_STR);
//             $stmt->bindParam(":medicineName", $param_batchName, PDO::PARAM_STR);
//             $stmt->bindParam(":method", $param_breedType, PDO::PARAM_STR);
//             $stmt->bindParam(":scheduleType", $param_batchPurpose, PDO::PARAM_STR);

//             // Set parameters
//             $param_age = $age;
//             $param_medicine_ID = $medicine_ID;
//             $param_batchName = $medicineName;
//             $param_breedType = $method;
//             $param_batchPurpose = $scheduleType;
//             // Attempt to execute the prepared statement
//             $stmt->execute();

//         }
//     }
// }


// for($counter = 0; $counter < 4; $counter ++){
//     // Select data from the generateschedules table for age 0
    
// }