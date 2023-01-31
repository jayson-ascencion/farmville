<?php
    //connect to the database
    include('../../../config/database_connection.php');
                      
    // Attempt select query execution
    // Select all medicine administration schedules where status is pending and order by ascending
    $sql = "SELECT * FROM medicines WHERE archive='not archived' ORDER BY medicine_ID ASC";
    $stmt = $conn->query($sql);
    if($stmt){
        if($stmt->rowCount() > 0){
            echo '<table id="medicineRecords" class="table table-sm responsive border table-hover text-center rounded rounded-3 overflow-hidden" style="width: 100%">';
                echo "<thead class='text-white' style='background-color: #2d4154'>";
                    echo "<tr>";
                        echo "<th>Medicine ID</th>";
                        echo "<th>Type</th>";
                        echo "<th>Name</th>";
                        echo "<th>Brand</th>";
                        echo "<th>Medicine For</th>";
                        echo "<th>Starting Quantity</th>";
                        echo "<th>In Stock</th>";
                        echo "<th>Date Added</th>";
                        echo "<th>Expiration Date</th>";
                        echo "<th>Action</th>";
                    echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                while($row = $stmt->fetch()){
                    //get dates from the row
                    $dateAdded = $row['dateAdded'];
                    $expirationDate = $row['expirationDate'];

                    //store the expiration date inside another variable and user strotime
                    $expDateSort = strtotime($row['expirationDate']);
                    $dateAddedSort = strtotime($row['dateAdded']);
                    //format the date
                    $expDateFormatted = date("M. d, Y", $expDateSort);
                    $dateAddedFormatted = date("M. d, Y", $dateAddedSort);

                    //date_create is used to create DateTime object  https://blog.devgenius.io/how-to-find-the-number-of-days-between-two-dates-in-php-1404748b1e84?gi=f10f685035f3 / https://stackoverflow.com/questions/2040560/finding-the-number-of-days-between-two-dates
                    $today = date_create(date('Y-m-d')); //generates current date
                    $expD = date_create($expirationDate);

                    //$newD = date('Y-m-d', strtotime($dateAdded. ' + 10 days'));
                    //calculates the difference between the two dates
                    $diff = date_diff($today,$expD);

                    //store the calculated days, %r -> used to include sign and if the number is positive it will be empty, %a -> total number of days as a result from the date_diff https://www.php.net/manual/en/dateinterval.format.php
                    $days = $diff->format('%r%a');

                    echo "<tr>";
                        echo "<td>" . $row['medicine_ID'] . "</td>";
                        echo "<td>" . $row['medicineType'] . "</td>";
                        echo "<td>" . $row['medicineName'] . "</td>";
                        echo "<td>" . $row['medicineBrand'] . "</td>";
                        echo "<td>" . $row['medicineFor'] . "</td>";
                        echo "<td>" . $row['startingQuantity'] . "</td>";
                        if($row['inStock'] < 10){
                            echo "<td>" . $row['inStock'] . '<span data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-expired" data-bs-title="Low In Stock"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-arrow-down-short" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 1 1 .708-.708L7.5 10.293V4.5A.5.5 0 0 1 8 4z"/>
                          </svg></span>' . "</td>";
                        }else{
                            echo "<td>" . $row['inStock'] . '<span data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-expired" data-bs-title="In Stock"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green" class="bi bi-arrow-up-short" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 12a.5.5 0 0 0 .5-.5V5.707l2.146 2.147a.5.5 0 0 0 .708-.708l-3-3a.5.5 0 0 0-.708 0l-3 3a.5.5 0 1 0 .708.708L7.5 5.707V11.5a.5.5 0 0 0 .5.5z"/>
                          </svg></span>' . "</td>";
                            //echo "<td>" . $row['inStock'] . "</td>";
                        }
                        echo "<td data-sort='". $dateAddedSort ."'>" . $dateAddedFormatted . "</td>"; //display format of date, doesnt affect the database
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
                        echo '<a href="update_med_form.php?id='. $row['medicine_ID'] .'" class="m-1 text-decoration-none" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-expired" data-bs-title="Edit Record">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                </svg>
                             </a>';
                        echo '<a href="viewMedicine.php?id='. $row['medicine_ID'] .'" class="m-1 text-decoration-none" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-expired" data-bs-title="View Record">
                             <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                 <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                 <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                             </svg>
                           </a>'; 
                        echo '<a href="archive_medicine.php?id='. $row['medicine_ID'] .'" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-expired" data-bs-title="Delete">
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
            echo '<table id="medicineRecords" class="table table-sm responsive border table-hover text-center rounded rounded-3 overflow-hidden" style="width: 100%">';
                echo "<thead class='text-white' style='background-color: #2d4154'>";
                    echo "<tr>";
                        echo "<th>Medicine ID</th>";
                        echo "<th>Type</th>";
                        echo "<th>Name</th>";
                        echo "<th>Brand</th>";
                        echo "<th>Medicine For</th>";
                        echo "<th>Starting Quantity</th>";
                        echo "<th>In Stock</th>";
                        echo "<th>Date Added</th>";
                        echo "<th>Expiration Date</th>";
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