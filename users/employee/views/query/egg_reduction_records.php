<?php
    //connect to the database
    include('../../../config/database_connection.php');
                      
    // Attempt select query execution
    // Select all medicine administration schedules where status is pending and order by ascending
    $sql = "SELECT * FROM eggtransaction WHERE archive = 'not archived' AND transactionType = 'Reduction' ORDER BY collection_ID ASC";
    $stmt = $conn->query($sql);
    if($stmt){
        if($stmt->rowCount() > 0){
            echo '
            <div id="filtertable" class="col-md-10 col-sm-12">
                <button id="reset-btn" class="border-secondary border-1 mx-1 p-1 rounded rounded-3 col-md-2 col-sm-4 m-1">Reset Filter</button>
            </div>
            <table id="eggProduction" class="table table-sm responsive border table-hover text-center rounded rounded-3 overflow-hidden" style="width: 100%">';
                echo "<thead class='text-white' style='background-color: #DC143C'>";
                    echo "<tr>";
                        echo "<th>Collection ID</th>";
                        echo "<th>Egg Size</th>";
                        echo "<th>Quantity Collected</th>";
                        echo "<th>Collection Type</th>";
                        echo "<th>Collection Date</th>";
                        //echo "<th>Note</th>";
                        echo "<th>Action</th>";
                    echo "</tr>";
                echo "</thead>";
                echo "<tbody class='text-break'>";
                while($row = $stmt->fetch()){
                    //get dates from the row
                    // $date = $row['collectionDate'];
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
                        echo "<td>" . $row['collection_ID'] . "</td>";
                        echo "<td>" . $row['eggSize'] . "</td>";
                        echo "<td>" . $row['quantity'] . "</td>";
                        // if($row['quantity'] < 10){
                        //     echo "<td>" . $row['quantity'] . '<span data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-expired" data-bs-title="Low In Stock"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-arrow-down-short" viewBox="0 0 16 16">
                        //     <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 1 1 .708-.708L7.5 10.293V4.5A.5.5 0 0 1 8 4z"/>
                        //   </svg></span>' . "</td>";
                        // }else{
                        //     echo "<td>" . $row['quantity'] . '<span data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-expired" data-bs-title="In Stock"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green" class="bi bi-arrow-up-short" viewBox="0 0 16 16">
                        //     <path fill-rule="evenodd" d="M8 12a.5.5 0 0 0 .5-.5V5.707l2.146 2.147a.5.5 0 0 0 .708-.708l-3-3a.5.5 0 0 0-.708 0l-3 3a.5.5 0 1 0 .708.708L7.5 5.707V11.5a.5.5 0 0 0 .5.5z"/>
                        //   </svg></span>' . "</td>";
                        //     //echo "<td>" . $row['inStock'] . "</td>";
                        // }
                        echo "<td>" . $row['dispositionType'] . "</td>";
                        echo "<td data-sort='". $dataSortExpD ."'>" . $expDateFormatted . "</td>";
                        //echo "<td>" . $row['note'] . "</td>";
                        echo "<td>";
                        //update icon/button
                        echo '<a href="update_eggreduction_form.php?id='. $row['collection_ID'] .'" class="m-1 text-decoration-none" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-expired" data-bs-title="Edit Record">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                </svg>
                            </a>';     
                        echo '<a href="viewEggReduction.php?id='. $row['collection_ID'] .'" class="m-1 text-decoration-none" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-expired" data-bs-title="View Record">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                </svg>
                              </a>'; 
                        echo '<a href="archive_egg_reduction.php?id='. $row['collection_ID'] .'" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-expired" data-bs-title="Archive">
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
        } 
        else{
            echo '
                
            <div id="filtertable" class="col-md-10 col-sm-12">
                <button id="reset-btn" class="border-secondary border-1 mx-1 p-1 rounded rounded-3 col-md-2 col-sm-4 m-1">Reset Filter</button>
            </div>

            <table id="eggProduction" class="table table-sm responsive border table-hover text-center rounded rounded-3 overflow-hidden" style="width: 100%">';
                echo "<thead class='text-white' style='background-color: #DC143C'>";
                    echo "<tr>";
                        echo "<th>Collection ID</th>";
                        echo "<th>Egg Size</th>";
                        echo "<th>Quantity Collected</th>";
                        echo "<th>Collection Type</th>";
                        echo "<th>Collection Date</th>";
                        //echo "<th>Note</th>";
                        echo "<th>Action</th>";
                    echo "</tr>";
                echo "</thead>";
                echo "<tbody class='text-break'>";
                while($row = $stmt->fetch()){
                }
                echo "</tbody>";                            
            echo "</table>";
            // Free stmt set
            unset($stmt);
            //echo '<div class="alert alert-danger text-center p-1 mt-5 m-5">No chicken production found. </div>';
        }
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }
    
    // Close connection
    unset($conn);

?>