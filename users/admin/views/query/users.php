<?php
    //connect to the database
    include('../../../config/database_connection.php');
                      
    // Attempt select query execution
    // Select all medicine administration schedules where status is pending and order by ascending
    $sql = "SELECT * FROM users ORDER BY user_ID ASC";
    $stmt = $conn->query($sql);
    if($stmt){
        if($stmt->rowCount() > 0){
            echo '
            <div id="filtertable" class="col-md-10 col-sm-12">
                <button id="reset-btn" class="border-secondary border-1 mx-1 p-1 rounded rounded-3 col-md-2 col-sm-4 m-1">Reset Filter</button>
            </div>
            <table id="users_disabled" class="table table-sm responsive border table-hover text-center rounded rounded-3 overflow-hidden" style="width: 100%">';
                echo "<thead class='text-white' style='background-color: #DC143C'>";
                    echo "<tr>";
                        echo "<th>User ID</th>";
                        echo "<th>First Name</th>";
                        echo "<th>Last Name</th>";
                        echo "<th>Contact Number</th>";
                        echo "<th>Role</th>";
                        echo "<th>Username</th>";
                        echo "<th>Status</th>";
                        echo "<th>Action</th>";
                    echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                while($row = $stmt->fetch()){
                    echo "<tr>";
                        echo "<td>" . $row['user_ID'] . "</td>";
                        echo "<td>" . $row['fname'] . "</td>";
                        echo "<td>" . $row['lname'] . "</td>";
                        echo "<td>" . $row['contact_num'] . "</td>";
                        // echo "<td>" . $row['role'] . "</td>";
                        echo "<td>";
                            if($row['role'] == 1) {
                                echo "Manager";
                            } elseif($row['role'] == 2) {
                                echo "Admin";
                            } elseif($row['role'] == 3) {
                                echo "Employee";
                            } else {
                                echo "Unknown";
                            }
                        echo "</td>";
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>";  
                            if($row['status'] == 'active'){
                                echo '<div class="badge rounded-pill bg-success text-white"> active</div>';
                            }else{
                                echo '<div class="badge rounded-pill bg-danger text-white">disabled</div>';
                            }
                        "</td>";
                        echo "<td>";
                        //update icon/button
                        echo '<a href="update_user.php?id='. $row['user_ID'] .'" class="m-1 text-decoration-none" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-expired" data-bs-title="Edit Record">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                </svg>
                            </a>';    
                        //view button
                        echo '<a href="view_user.php?id='. $row['user_ID'] .'" class="m-1 text-decoration-none" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-expired" data-bs-title="View Record">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                </svg>
                              </a>';       
                        // if($row["status"] == 'active'){
                        //     echo '<a href="user_access.php?id='. $row['user_ID'] .'" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-expired" data-bs-title="Access Granted">
                        //     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray" class="bi bi-unlock-fill" viewBox="0 0 16 16">
                        //     <path d="M11 1a2 2 0 0 0-2 2v4a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h5V3a3 3 0 0 1 6 0v4a.5.5 0 0 1-1 0V3a2 2 0 0 0-2-2z"/>
                        //     </svg>
                        //     </a>';
                        // }else{
                        //     echo '<a href="user_access.php?id='. $row['user_ID'] .'" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-expired" data-bs-title="Access Denied">
                        //     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray" class="bi bi-lock-fill" viewBox="0 0 16 16">
                        //     <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                        //     </svg>
                        //     </a>';
                        // }                                      
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

            <table id="users_disabled" class="table table-sm responsive border table-hover text-center rounded rounded-3 overflow-hidden" style="width: 100%">';
            echo "<thead class='text-white' style='background-color: #DC143C'>";
                echo "<tr>";
                    echo "<th>User ID</th>";
                    echo "<th>First Name</th>";
                    echo "<th>Last Name</th>";
                    echo "<th>Contact Number</th>";
                    echo "<th>Role</th>";
                    echo "<th>Username</th>";
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
 