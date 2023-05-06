<?php
    //connect to the database
    include('../../../config/database_connection.php');
                      
    // Attempt select query execution
    // Select all medicine administration schedules where status is pending and order by ascending
    $sql = "SELECT * FROM medicinetransaction WHERE transactionType = 'replenishment' AND archive = 'archived' ORDER BY medicine_ID ASC";
    $stmt = $conn->query($sql);
    if($stmt){
        if($stmt->rowCount() > 0){
            echo '
            <div id="filterReplenishment" class="col-md-10 col-sm-12">
                <button id="reset-btn-filter" class="border-secondary border-1 mx-1 p-1 rounded rounded-3 col-md-2 col-sm-4 m-1">Reset Filter</button>
            </div>
            <table id="medicine_replenishment" class="table table-sm responsive border table-hover text-center rounded rounded-3 overflow-hidden" style="width: 100%">';
                echo "<thead class='text-white' style='background-color: #DC143C'>";
                    echo "<tr>";
                        echo "<th>Transaction ID</th>";
                        echo "<th>Name</th>";
                        echo "<th>Quantity</th>";
                        // echo "<th>Reduction Type</th>";
                        echo "<th>Date Added</th>";
                        echo "<th>Expiration Date</th>";
                        // echo "<th>Starting Quantity</th>";
                        // echo "<th>In Stock</th>";
                        // echo "<th>Date Added</th>";
                        // echo "<th>Expiration Date</th>";
                        echo "<th>Action</th>";
                    echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                while($row = $stmt->fetch()){
                    //get dates from the row
                    // $dateAdded = $row['dateAdded'];
                    $expirationDate = $row['expirationDate'];
                    
                    // $reorderPoint = $row['startingQuantity']*.25;
                    // print_r($reorderPoint);

                    //store the expiration date inside another variable and user strotime
                    $expDateSort = strtotime($row['expirationDate']);
                    // $dateAddedSort = strtotime($row['dateAdded']);
                    //format the date
                    $expDateFormatted = date("M. d, Y", $expDateSort);
                    // $dateAddedFormatted = date("M. d, Y", $dateAddedSort);

                    //date_create is used to create DateTime object  https://blog.devgenius.io/how-to-find-the-number-of-days-between-two-dates-in-php-1404748b1e84?gi=f10f685035f3 / https://stackoverflow.com/questions/2040560/finding-the-number-of-days-between-two-dates
                    $today = date_create(date('Y-m-d')); //generates current date
                    $expD = date_create($expirationDate);

                    //$newD = date('Y-m-d', strtotime($dateAdded. ' + 10 days'));
                    //calculates the difference between the two dates
                    $diff = date_diff($today,$expD);

                    //store the calculated days, %r -> used to include sign and if the number is positive it will be empty, %a -> total number of days as a result from the date_diff https://www.php.net/manual/en/dateinterval.format.php
                    $days = $diff->format('%r%a');

                    echo "<tr>";
                        echo "<td>" . $row['transaction_ID'] . "</td>";
                        echo "<td>" . $row['medicineName'] . "</td>";
                        // echo "<td>" . $row['medicineBrand'] . "</td>";
                        echo "<td>" . $row['quantity'] . "</td>";
                        echo "<td>" . $row['transactionDate'] . "</td>";
                        // echo "<td>" . $row['expirationDate'] . "</td>";
                        // if($row['inStock'] < 5){
                        //     echo "<td>" . $row['inStock'] . '<span data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-expired" data-bs-title="Low In Stock"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-arrow-down-short" viewBox="0 0 16 16">
                        //     <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 1 1 .708-.708L7.5 10.293V4.5A.5.5 0 0 1 8 4z"/>
                        //   </svg></span>' . "</td>";
                        // }else{
                        //     echo "<td>" . $row['inStock'] . '<span data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-expired" data-bs-title="In Stock"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green" class="bi bi-arrow-up-short" viewBox="0 0 16 16">
                        //     <path fill-rule="evenodd" d="M8 12a.5.5 0 0 0 .5-.5V5.707l2.146 2.147a.5.5 0 0 0 .708-.708l-3-3a.5.5 0 0 0-.708 0l-3 3a.5.5 0 1 0 .708.708L7.5 5.707V11.5a.5.5 0 0 0 .5.5z"/>
                        //   </svg></span>' . "</td>";
                        //     //echo "<td>" . $row['inStock'] . "</td>";
                        // }
                        // echo "<td data-sort='". $dateAddedSort ."'>" . $dateAddedFormatted . "</td>"; //display format of date, doesnt affect the database
                        //if days is lesser than or equals to zero, then the medicine is expired
                        if($days < 1){
                            echo "<td data-sort='". $expDateSort ."'>" . $expDateFormatted .
                                    '<span data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-expired" data-bs-title="Medicine is expired."> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-exclamation-circle-fill" viewBox="0 0 16 16">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                                        </svg> 
                                    </span>' .
                                "</td>"; 
                        }
                        else if($days < 60){ //if days is lesser than 60 then the medicine is about to expire
                            echo "<td data-sort='". $expDateSort ."'>" . $expDateFormatted  .
                                    '<span data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-expired" data-bs-title="Medicine is about to expire."> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="orange" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                                    </svg> </span>' .
                                "</td>"; 
                        }
                        else if($days >= 60){ //if days is greater than 60 to zero, then the medicine not expired or not about to expire
                            echo "<td data-sort='". $expDateSort ."'>" . $expDateFormatted  .
                                    '<span data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-expired" data-bs-title="Good."> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green" class="bi bi-check-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                                    </svg><span>' .
                                "</td>"; 
                        }
                        echo "<td>";
                        //update icon/button
                        echo '<a href="restore_medicine.php?id='. $row['transaction_ID'] .'" class="m-1 text-decoration-none" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-expired" data-bs-title="Restore">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/>
                        <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/>
                      </svg>
                            </a>';
                        echo '<a href="delete_medicine.php?id='. $row['transaction_ID'] .'" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-expired" data-bs-title="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                    <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                </svg>
                            </a>';                                          
                        echo "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";                            
            echo "</table>";
            // Free stmt set
            unset($stmt);
        } else{
            echo '
                
            <div id="filterReplenishment" class="col-md-10 col-sm-12">
                <button id="reset-btn-filter" class="border-secondary border-1 mx-1 p-1 rounded rounded-3 col-md-2 col-sm-4 m-1">Reset Filter</button>
            </div>

            <table id="medicine_replenishment" class="table table-sm responsive border table-hover text-center rounded rounded-3 overflow-hidden" style="width: 100%">';
                echo "<thead class='text-white' style='background-color: #DC143C'>";
                    echo "<tr>";
                       // echo "<th>Medicin
                        echo "<th>Transaction ID</th>";
                        echo "<th>Name</th>";
                        echo "<th>Quantity</th>";
                        // echo "<th>Reduction Type</th>";
                        echo "<th>Date Added</th>";
                        echo "<th>Expiration Date</th>";
                        // echo "<th>Starting Quantity</th>";
                        // echo "<th>In Stock</th>";
                        // echo "<th>Date Added</th>";
                        // echo "<th>Expiration Date</th>";
                        echo "<th>Action</th>";
                    echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                while($row = $stmt->fetch()){
                    
                }
                echo "</tbody>";                            
            echo "</table>";
        }
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }
    
    // Close connection
    unset($conn);

?>