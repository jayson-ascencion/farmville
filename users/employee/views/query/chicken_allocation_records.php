<?php
    //connect to the database
    include('../../../config/database_connection.php');
                      
    // Attempt select query execution
    // Select all medicine administration schedules where status is pending and order by ascending
    $sql = "SELECT * FROM chickentransaction WHERE archive='not archived' AND dispositionType = 'allocation' ORDER BY transaction_ID ASC";
    $stmt = $conn->query($sql);
    if($stmt){
        if($stmt->rowCount() > 0){
            echo '
            <div id="filterAllocation" class="col-md-10 col-sm-12">
                <button id="reset-btn-allocation" class="border-secondary border-1 mx-1 p-1 rounded rounded-3 col-md-2 col-sm-4 m-1">Reset Filter</button>
            </div>
            <table id="chickenAllocation" class="table table-sm responsive border table-hover text-center rounded rounded-3 overflow-hidden" style="width: 100%">';
                echo "<thead class='text-white' style='background-color: #DC143C'>";
                    echo "<tr>";
                        echo "<th>Transaction ID</th>";
                        // echo "<th>Batch ID</th>";
                        echo "<th>Coop Number</th>";
                        echo "<th>Batch Name</th>";
                        echo "<th>Sex</th>";
                        echo "<th>Quantity</th>";
                        // echo "<th>Disposition Type</th>";
                        echo "<th>Date Allocated</th>";
                        echo "<th>Action</th>";
                    echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                while($row = $stmt->fetch()){
                    //get dates from the row
                    $transactionDate = $row['transactionDate'];
                    //$expirationDate = $row['expirationDate'];

                    //store the expiration date inside another variable and user strotime
                    $dataSortExpD = strtotime($row['transactionDate']);
                    //format the date
                    $expDateFormatted = date("M. d, Y", $dataSortExpD);

                    //date_create is used to create DateTime object  https://blog.devgenius.io/how-to-find-the-number-of-days-between-two-dates-in-php-1404748b1e84?gi=f10f685035f3 / https://stackoverflow.com/questions/2040560/finding-the-number-of-days-between-two-dates
                    //$today = date_create(date('Y-m-d')); //generates current date
                    //$expD = date_create($expirationDate);

                    //calculates the difference between the two dates
                   // $diff = date_diff($today,$expD);

                    //store the calculated days, %r -> used to include sign and if the number is positive it will be empty, %a -> total number of days as a result from the date_diff https://www.php.net/manual/en/dateinterval.format.php
                   // $days = $diff->format('%r%a');

                    echo "<tr>";
                        echo "<td>" . $row['transaction_ID'] . "</td>";
                        // echo "<td>" . $row['chickenBatch_ID'] . "</td>";
                        echo "<td>" . $row['coopNumber'] . "</td>";
                        echo "<td>" . $row['batchName'] . "</td>";
                        echo "<td>" . $row['sex'] . "</td>";
                        echo "<td>" . $row['quantity'] . "</td>";
                        // echo "<td>" . $row['dispositionType'] . "</td>";
                        echo "<td data-sort='". $dataSortExpD ."'>" . $expDateFormatted  . "</td>"; //display format of date, doesnt affect the database
                        echo "<td>";
                        //update icon/button
                        echo '<a href="update_chick_allocation.php?id='. $row['transaction_ID'] .'" class="m-1 text-decoration-none" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-expired" data-bs-title="Edit Record">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                </svg>
                            </a>';
                        echo '<a href="viewChick.php?id='. $row['transaction_ID'] .'" class="m-1 text-decoration-none" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-expired" data-bs-title="View Record">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                </svg>
                            </a>'; 
                        echo '<a href="archive_chicken.php?id='. $row['transaction_ID'] .'" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-expired" data-bs-title="Archive">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray" class="bi bi-archive-fill" viewBox="0 0 16 16">
                                    <path d="M12.643 15C13.979 15 15 13.845 15 12.5V5H1v7.5C1 13.845 2.021 15 3.357 15h9.286zM5.5 7h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1zM.8 1a.8.8 0 0 0-.8.8V3a.8.8 0 0 0 .8.8h14.4A.8.8 0 0 0 16 3V1.8a.8.8 0 0 0-.8-.8H.8z"/>
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
                
            <div id="filterAllocation" class="col-md-10 col-sm-12">
                <button id="reset-btn-allocation" class="border-secondary border-1 mx-1 p-1 rounded rounded-3 col-md-2 col-sm-4 m-1">Reset Filter</button>
            </div>

            <table id="chickenAllocation" class="table table-sm responsive border table-hover text-center rounded rounded-3 overflow-hidden" style="width: 100%">';
            echo "<thead class='text-white' style='background-color: #DC143C'>";
                echo "<tr>";
                    echo "<th>Transaction ID</th>";
                    // echo "<th>Batch ID</th>";
                    echo "<th>Coop Number</th>";
                    echo "<th>Batch Name</th>";
                    echo "<th>Sex</th>";
                    echo "<th>Quantity</th>";
                    // echo "<th>Disposition Type</th>";
                    echo "<th>Date Allocated</th>";
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