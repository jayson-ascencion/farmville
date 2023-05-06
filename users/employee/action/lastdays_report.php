<?php
 //statement get the last 7 days
 $oneweek = ['No Data'];
 $oneweekDataset = [0];
 $lastdaysBatch = ['No Data'];
 $sql = "SELECT SUM(COALESCE(inStock, 0)) as instock, batchName, DATE_FORMAT(dateAcquired, '%M %d') AS acquiredDate FROM chickenproduction WHERE dateAcquired BETWEEN CURDATE() - INTERVAL 6 DAY AND CURDATE() GROUP BY acquiredDate";
 $stmt = $conn->query($sql);
  if($stmt){
      if($stmt->rowCount() > 0){
         $oneweek = array();
         $oneweekDataset = array();
         // $oneweekDatasetReductions = array();
         $lastdaysBatch = array();
         while($row = $stmt->fetch()){
             $oneweek[] = $row['acquiredDate'];
             $oneweekDataset[] = $row['instock'];
             // $oneweekDatasetReductions = $row['totalReductions'];
             $lastdaysBatch[] = $row['batchName'];

             // $oneweek[] = (is_null($row['acquiredDate'])) ? date('Y-m-d') : $row['acquiredDate'];
             // $oneweekDataset[] = (is_null($row['instock'])) ? 0 : $row['instock'];
             // $lastdaysBatch[] = (is_null($row['batchName'])) ? 'No Data' : $row['batchName'];
         }
         // Free result set
         unset($result);
     }
 }
 else{
     echo "Oops! Something went wrong. Please try again later.";
 }
?>