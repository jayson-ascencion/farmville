<?php
    //connect to the database
    include('../../../config/database_connection.php');
                      
    // Attempt select query execution
    // Select all the chicken production data from the database
            
    $sql = "SELECT * FROM chickenproduction WHERE archive='archived' ORDER BY chickenBatch_ID ASC";
    $stmt = $conn->query($sql);
    if($stmt){
        if($stmt->rowCount() > 0){
            // <button id="resetFilter">Reset Filter</button>
            echo '
                
            <div id="filtertable" class="col-md-10 col-sm-12">
                <button id="reset-btn" class="border-secondary border-1 mx-1 p-1 rounded rounded-3 col-md-2 col-sm-4 m-1">Reset Filter</button>
            </div>

            <table id="chickenProduction" class="table table-sm responsive border table-hover text-center rounded rounded-3 overflow-hidden" style="width: 100%">';
                echo "<thead class='text-white' style='background-color: #DC143C'>"; 
                    echo "<tr>";
                        echo "<th>Batch ID</th>";
                        echo "<th>Coop Number</th>";
                        echo "<th>Batch Name</th>";
                        echo "<th>Breed Type</th>";
                        echo "<th>Batch Purpose</th>";
                        echo "<th>Starting Quantity</th>";
                        echo "<th>In Stock</th>";
                        echo "<th>Date Acquired</th>";
                        echo "<th>Acquisition Type</th>";
                        // echo "<th>Note</th>";
                        echo "<th>Action</th>";
                    echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                while($row = $stmt->fetch()){
                    //gets the date from the row
                    $dateAcquired = $row['dateAcquired'];

                    //store the date acquired date inside another variable and user strotime
                    $dateSortAcquired = strtotime($row['dateAcquired']);

                    //format the date
                    $dateFormatted = date("M. d, Y", $dateSortAcquired);

                    //date_create is used to create DateTime object  https://blog.devgenius.io/how-to-find-the-number-of-days-between-two-dates-in-php-1404748b1e84?gi=f10f685035f3 / https://stackoverflow.com/questions/2040560/finding-the-number-of-days-between-two-dates
                    $today = date_create(date('Y-m-d')); //generates current date
                    $dateAcquiredDateCreate = date_create($dateAcquired);

                    //$newD = date('Y-m-d', strtotime($dateAdded. ' + 10 days'));
                    //calculates the difference between the two dates
                    $diff = date_diff($dateAcquiredDateCreate,$today);

                    //store the calculated days, %r -> used to include sign and if the number is positive it will be empty, %a -> total number of days as a result from the date_diff https://www.php.net/manual/en/dateinterval.format.php
                    $days = $diff->format('%r%a');

                    echo "<tr>";
                        echo "<td>" . $row['chickenBatch_ID'] . "</td>";
                        echo "<td>" . $row['coopNumber'] . "</td>";
                        echo "<td>" . $row['batchName'] . "</td>";
                        echo "<td>" . $row['breedType'] . "</td>";
                        echo "<td>" . $row['batchPurpose'] . "</td>";
                        echo "<td>" . $row['startingQuantity'] . "</td>";
                        // echo "<td>" . $row['inStock'] . "</td>";
                        //
                        if($row['inStock'] < $row['startingQuantity']*.25){
                            echo "<td>" . $row['inStock'] . '<span data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-expired" data-bs-title="Low In Stock"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-arrow-down-short" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 1 1 .708-.708L7.5 10.293V4.5A.5.5 0 0 1 8 4z"/>
                          </svg></span>' . "</td>";
                        }else{
                            echo "<td>" . $row['inStock'] . '<span data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-expired" data-bs-title="In Stock"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green" class="bi bi-arrow-up-short" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 12a.5.5 0 0 0 .5-.5V5.707l2.146 2.147a.5.5 0 0 0 .708-.708l-3-3a.5.5 0 0 0-.708 0l-3 3a.5.5 0 1 0 .708.708L7.5 5.707V11.5a.5.5 0 0 0 .5.5z"/>
                          </svg></span>' . "</td>";
                            //echo "<td>" . $row['inStock'] . "</td>";
                        }
                        //
                        echo "<td data-sort='". $dateSortAcquired ."'>" . $dateFormatted . "</td>"; //display format of date, doesnt affect the database
                        echo "<td>" . $row['acquisitionType'] . "</td>";
                        // echo "<td>" . $row['note'] . "</td>";
                        echo "<td>";
                        //update icon/button
                        echo '<a href="restore_chicken.php?id='. $row['chickenBatch_ID'] .'" class="m-1 text-decoration-none" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-expired" data-bs-title="Restore">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/>
                        <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/>
                      </svg>
                            </a>';   
                        echo '<a href="delete_chicken.php?id='. $row['chickenBatch_ID'] .'" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-expired" data-bs-title="Delete">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                        <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                      </svg>
                        </a>';   
                        echo "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";   
            //     echo "
            //     <tfoot>
                
            //     <tr>
            //     <th>Batch ID</th>
            //     <th>Coop Number</th>
            //     <th>Batch Name</th>
            //     <th>Breed Type</th>
            //     <th>Batch Purpose</th>
            //     <th>Starting Quantity</th>
            //     <th>In Stock</th>
            //     <th>Date Acquired</th>
            //     <th>Acquisition Type</th>
            //     <th>Action</th>
            // </tr>
            //     </tfoot>
            //     ";           
            echo "</table>";
            // Free stmt set
            unset($stmt);
        } else{
            echo '
                
            <div id="filtertable" class="col-md-10 col-sm-12">
                <button id="reset-btn" class="border-secondary border-1 mx-1 p-1 rounded rounded-3 col-md-2 col-sm-4 m-1">Reset Filter</button>
            </div>

            <table id="chickenProduction" class="table table-sm responsive border table-hover text-center rounded rounded-3 overflow-hidden" style="width: 100%">';
                echo "<thead class='text-white' style='background-color: #DC143C'>"; 
                    echo "<tr>";
                        echo "<th>Batch ID</th>";
                        echo "<th>Coop Number</th>";
                        echo "<th>Batch Name</th>";
                        echo "<th>Breed Type</th>";
                        echo "<th>Batch Purpose</th>";
                        echo "<th>Starting Quantity</th>";
                        echo "<th>In Stock</th>";
                        echo "<th>Date Acquired</th>";
                        echo "<th>Acquisition Type</th>";
                        // echo "<th>Note</th>";
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