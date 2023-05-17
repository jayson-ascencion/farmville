<?php
    //connect to the database
    include('../../../config/database_connection.php');

    // Select all medicine administration schedules where status is completed and order by administration schedule in ascending oder
    $sql = "SELECT * FROM schedules WHERE archive = 'archived' ORDER BY administrationSched ASC";
    $stmt = $conn->query($sql);
    if($stmt){
        if($stmt->rowCount() > 0){
            echo '
                
            <div id="filtertable" class="col-md-12 col-sm-12">
                <button id="reset-btn" class="border-secondary border-1 mx-1 p-1 rounded rounded-3 col-md-2 col-sm-4 m-1" style="width: 150px">Reset Filter</button>
            </div>

           <table id="schedules_Delete" class="table table-sm  border responsive table-hover text-center rounded rounded-3 overflow-hidden" style="width: 100%">';
                echo "<thead class='text-white' style='background-color: #DC143C'>";
                    echo "<tr>";
                        echo "<th>Schedule Type</th>";
                        echo "<th>Administration ID</th>";
                        echo "<th>Chicken Batch ID</th>";
                        echo "<th>Coop Number</th>";
                        echo "<th>Medicine Name</th>";
                        echo "<th>Method</th>";
                        echo "<th>Dosage</th>";
                        echo "<th>Number of Chicken </th>";
                        echo "<th>Schedule</th>";
                        echo "<th>Status</th>";
                        echo "<th>Action</th>";               
                    echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                while($row = $stmt->fetch()){
                    
                    //store the expiration date inside another variable and use strotime
                    $date = strtotime($row['administrationSched']);
                    //format the date
                    $schedule = date("M. d, Y", $date);

                    echo "<tr>";
                        echo "<td>" . $row['scheduleType'] . "</td>";
                        echo "<td>" . $row['administration_ID'] . "</td>";
                        echo "<td>" . $row['chickenBatch_ID'] . "</td>";
                        echo "<td>" . $row['coopNumber'] . "</td>";
                        echo "<td>" . $row['medicineName'] . "</td>";
                        echo "<td>" . $row['methodType'] . "</td>";
                        echo "<td>" . $row['dosage'] . "</td>";
                        echo "<td>" . $row['numberHeads'] . "</td>";
                        echo "<td data-sort='". $date ."'>" . $schedule . "</td>"; //display date in specified format, does not affect the database. D - represents day in words, M - represents month in words, d - represents day in numerical format
                        
                        if($row['status']==='completed'){
                            echo "<td><div class='badge rounded-pill bg-success text-white'>" . $row['status'] . "</div></td>";
                        }else{
                            echo "<td><div class='badge rounded-pill bg-danger text-white'>" . $row['status'] . "</div></td>";
                        }
                        echo "<td>";
                        //update icon/button
                        echo '<a href="restore_schedules.php?id='. $row['administration_ID'] .'" class="m-1 text-decoration-none" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-expired" data-bs-title="Restore">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/>
                        <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/>
                      </svg>
                            </a>';
                        echo '<a href="delete_schedules.php?id='. $row['administration_ID'] .'" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-expired" data-bs-title="Delete">
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
            <div id="filtertable" class="col-md-12 col-sm-12">
            <button id="reset-btn" class="border-secondary border-1 mx-1 p-1 rounded rounded-3 col-md-2 col-sm-4 m-1" style="width: 150px">Reset Filter</button>
        </div>

       <table id="schedules_Delete" class="table table-sm  border responsive table-hover text-center rounded rounded-3 overflow-hidden" style="width: 100%">';
            echo "<thead class='text-white' style='background-color: #DC143C'>";
                echo "<tr>";
                    echo "<th>Schedule Type</th>";
                    echo "<th>Administration ID</th>";
                    echo "<th>Chicken Batch ID</th>";
                    echo "<th>Coop Number</th>";
                    echo "<th>Medicine Name</th>";
                    echo "<th>Method</th>";
                    echo "<th>Dosage</th>";
                    echo "<th>Number of Chicken </th>";
                    echo "<th>Schedule</th>";
                    echo "<th>Status</th>";
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