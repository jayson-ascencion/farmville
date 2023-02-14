<?php
    //page title
    $title = " Vaccination Details";
    
    //header
    include('../../includes/header.php');

    //connect to the database
    include('../../../config/database_connection.php');

    //store id being passed from the prev page to be used in displaying data
    $id = $_REQUEST['id'];

    //statement to select the specific schedule to update
    $sql = "SELECT * FROM schedules WHERE administration_ID = '$id'";
    $stmt = $conn->query($sql);
    if($stmt){
    if($stmt->rowCount() > 0){
        while($row = $stmt->fetch()){
        $chickenBatch_ID = $row['chickenBatch_ID'];
        $coopNumber = $row['coopNumber'];
        $medicine_ID = $row['medicine_ID'];
        $medicineName = $row['medicineName'];
        $methodType = $row['methodType'];
        $dosage = $row['dosage'];
        $numberHeads = $row['numberHeads'];
        $administrationSched = $row['administrationSched'];
        $administeredBy = $row['administeredBy'];
        $status = $row['status'];
        $notes = $row['notes'];
        }
        // Free result set
        unset($result);
    } else{
        echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
    }
    } else{
    echo "Oops! Something went wrong. Please try again later.";
    }
    unset($stmt);
?>

<!-- content --> 
<div class="container-fluid px-4">
    <h1 class="mt-4"> Administrator Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a class="text-decoration-none" href="./vaccination_pending.php">Vaccination Schedules</a>
        </li>
        <li class="breadcrumb-item active">View Details</li>
    </ol>


    <div class="row justify-content-center mt-2">
        <div class="col-sm-4">
            <div class="card bg-light shadow-lg mb-4 ">
                <div class="card-header text-center fw-bold d-flex justify-content-between p-3" style="background-color: #FFAF1A; color: #91452c">
                    <div>VACCINATION SCHEDULE</div> 
                    <div>
                        <a class="small text-white" href="./vaccination_completed.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z"/>
                                <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
                            </svg>
                        </a> 
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- CHICKEN BATCH ID -->
                    <div class="mb-3">
                        <p class="fw-bold">Chicken Batch ID: <span class="fw-normal ps-2"><?php echo $chickenBatch_ID; ?></span></p>
                    </div>

                    <!-- COOP NUMBER -->
                    <div class="mb-3">
                        <p class="fw-bold">Coop Number: <span class="fw-normal ps-2"><?php echo $coopNumber; ?></span></p>
                    </div>

                    <!-- MEDICINE ID -->
                    <div class="mb-3">
                        <p class="fw-bold">Medicine ID: <span class="fw-normal ps-2"><?php echo $medicine_ID; ?></span></p>
                    </div>

                    <!-- MEDICINE NAME -->
                    <div class="mb-3">
                        <p class="fw-bold">Medicine Name: <span class="fw-normal ps-2"><?php echo $medicineName; ?></span></p>
                    </div>

                    <!-- MEDICATION TYPE -->
                    <div class="mb-3">
                        <p class="fw-bold">Vaccination Type: <span class="fw-normal ps-2"><?php echo $methodType; ?></span></p>
                    </div>

                    <!-- DOSAGE -->
                    <div class="mb-3">
                        <p class="fw-bold">Dosage: <span class="fw-normal ps-2"><?php echo $dosage; ?></span></p>
                    </div>

                    <!-- NUMBER HEADS -->
                    <div class="mb-3">
                        <p class="fw-bold">Number of Heads: <span class="fw-normal ps-2"><?php echo $numberHeads; ?></span></p>
                    </div>

                    <!-- ADMINISTRATION SCHED -->
                    <div class="mb-3">
                        <p class="fw-bold">Schedule: <span class="fw-normal ps-2"><?php echo $administrationSched; ?></span></p>
                    </div>
                    
                    <?php   
                    //statement to select the all the medicine names
                    $sql = "SELECT username FROM users WHERE user_ID = '$administeredBy'";
                    $stmt = $conn->query($sql);

                    if($stmt){
                        if($stmt->rowCount() > 0){
                            while($row = $stmt->fetch()){
                                $employee = $row['username'];
                            }
                            // Free result set
                            unset($stmt);
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
                    ?>
                    <!-- ADMINISTERED BY -->
                    <div class="mb-3">
                        <p class="fw-bold">Administered By: <span class="fw-normal ps-2"><?php echo $employee; ?></span></p>
                    </div>

                    <!-- STATUS -->
                    <div class="mb-3">
                        <p class="fw-bold">Status: <span class="fw-normal ps-2"><?php echo $status; ?></span></p>
                    </div>

                    <!-- NOTES -->
                    <div class="mb-3">
                        <p class="fw-bold">Notes: <span class="fw-normal ps-2"><?php echo $notes; ?></span></p>
                    </div>

                </div>
                    
            </div>
        </div>
    </div>
</div>
<!-- end of content -->

<?php
    //header
    include('../../includes/footer.php');

    //scripts
    include('../../includes/scripts.php');
?>
