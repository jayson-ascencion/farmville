<?php
    //connect to the database
    include('../../../config/database_connection.php');

    //this is id will be use to display specific sched assigned to the employee
    $employee_ID = $_SESSION["user_ID"];

    // Select all medicine administration schedules where status is pending and order by ascending
    $sql = "SELECT * FROM schedules WHERE scheduleType = 'vaccination' AND status = 'pending' AND archive = 'not archived' AND administeredBy = $employee_ID ORDER BY administrationSched ASC";
    $stmt = $conn->query($sql);
    if($stmt){
        if($stmt->rowCount() > 0){
            echo '
            <div id="filtertable" class="col-md-10 col-sm-12">
                <button id="reset-btn" class="border-secondary border-1 mx-1 p-1 rounded rounded-3 col-md-2 col-sm-4 m-1">Reset Filter</button>
            </div>

           <table id="vaccinationSchedules" class="table border table-sm responsive table-hover text-center rounded rounded-3 overflow-hidden" style="width: 100%">';
                echo "<thead class='text-white' style='background-color: #DC143C'>";
                    echo "<tr>";
                        echo "<th>Administration ID</th>";
                        echo "<th>Chicken Batch ID</th>";
                        echo "<th>Coop Number</th>";
                        echo "<th>Medicine Name</th>";
                        echo "<th>Vaccination Type</th>";
                        echo "<th>Dosage</th>";
                        echo "<th>Number of Chicken </th>";
                        echo "<th>Schedule</th>";
                        echo "<th>Status</th>";
                        echo "<th>Action</th>";   
                    echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                while($row = $stmt->fetch()){
                    //store the expiration date inside another variable and user strotime
                    $date = strtotime($row['administrationSched']);
                    //format the date
                    $schedule = date("M. d, Y", $date);
                    echo "<tr>";
                        echo "<td>" . $row['administration_ID'] . "</td>";
                        echo "<td>" . $row['chickenBatch_ID'] . "</td>";
                        echo "<td>" . $row['coopNumber'] . "</td>";
                        echo "<td>" . $row['medicineName'] . "</td>";
                        echo "<td>" . $row['methodType'] . "</td>";
                        echo "<td>" . $row['dosage'] . "</td>";
                        echo "<td>" . $row['numberHeads'] . "</td>";
                        echo "<td data-sort='". $date ."'>" . $schedule . "</td>"; //display format of date, doesnt affect the database
                        echo "<td><div class='badge rounded-pill bg-danger text-white'>" . $row['status'] . "</div></td>";
                        echo "<td>";
                        //update icon/button
                            echo '<a href="update_vaccination_pending.php?id='. $row['administration_ID'] .'" class="m-1 text-decoration-none" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-expired" data-bs-title="Edit Record">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                    </svg>
                                </a>';
                            //view button
                            echo '<a href="view_pending_vac.php?id='. $row['administration_ID'] .'" class="m-1 text-decoration-none" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-expired" data-bs-title="View Record">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
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
            <div id="filtertable" class="col-md-10 col-sm-12">
                <button id="reset-btn" class="border-secondary border-1 mx-1 p-1 rounded rounded-3 col-md-2 col-sm-4 m-1">Reset Filter</button>
            </div>

           <table id="vaccinationSchedules" class="table border table-sm responsive table-hover text-center rounded rounded-3 overflow-hidden" style="width: 100%">';
                echo "<thead class='text-white' style='background-color: #DC143C'>";
                    echo "<tr>";
                        echo "<th>Administration ID</th>";
                        echo "<th>Chicken Batch ID</th>";
                        echo "<th>Coop Number</th>";
                        echo "<th>Medicine Name</th>";
                        echo "<th>Vaccination Type</th>";
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